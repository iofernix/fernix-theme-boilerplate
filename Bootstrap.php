<?php

namespace Fernix\Script;

use Composer\Script\Event;

class Bootstrap
{
    public static function init(Event $event)
    {
        $io = $event->getIO();
        $projectPath = dirname(realpath(\Composer\Factory::getComposerFile()));
        $projectName = basename($projectPath);
        $projectDate = date("Y");

        $mapping = array(
            $io->ask("Theme name [$projectName] : ", $projectName),
            $io->ask("Theme namespace [Fernix] : ", "Fernix"),
            $io->ask("Author [Fernix] : ", "Fernix"),
            $io->ask("Author email [info@fernix.io] : ", "info@fernix.io"),
            $io->ask("Copyright [$projectDate IO Fernix LLC] : ", "$projectDate IO Fernix LLC"),
            $io->ask("License [MIT] : ", "MIT")
        );

        $mapping[0] = implode('_', explode(' ', ucwords($mapping[0])));
        $mapping[1] = implode('_', explode(' ', ucwords($mapping[1])));
        $mapping[6] = implode('-', explode(' ', strtolower($mapping[0])));

        self::renameProjectFiles($projectPath, $mapping);
    }

    public static function renameProjectFiles($path, $mapping)
    {
        $directory = new \DirectoryIterator($path);
        $iterator = new \IteratorIterator($directory);

        $themeName = $mapping[0];
        $themeNamespace = $mapping[1];
        $themeFilename = $mapping[6];
        $themeAuthor = $mapping[2];
        $themeAuthorEmail = $mapping[3];
        $themeCopyright = $mapping[4];
        $themeLicense = $mapping[5];

        foreach ($iterator as $file) {
            $filePathName = $file->getPathname();
            $fileExtension = $file->getExtension();

            if ($file->isDir() && !$file->isDot()) {
                if(preg_match('/\{theme-name\}/', $filePathName)) {
                    $newFilePathName = preg_replace('/\{theme-name\}/', $themeFilename, $filePathName);

                    if(rename($filePathName, $newFilePathName)) {
                        self::renameProjectFiles($newFilePathName, $mapping);
                    }
                }else {
                    self::renameProjectFiles($filePathName, $mapping);
                }
            }

            if($file->isFile()) {
                if(!preg_match('/\b(jpg|png|svg)\b/', $fileExtension) && preg_match('/\b(' . $themeFilename . ')\b/', $filePathName)) {
                    $fileContent = implode("", file($filePathName));
                    $match_count = preg_match_all('/#\{Theme_Name\}|#\{Theme_Namespace\}|#\{theme-name\}/', $fileContent);
        
                    if($match_count) {
                        $fp = fopen($filePathName, 'w');
        
                        $fileContent = preg_replace(array(
                            '/#\{Theme_Name\}/',
                            '/#\{Theme_Namespace\}/',
                            '/#\{theme-name\}/',
                            '/#\{theme-namespace\}/',
                            '/#\{Author\}/',
                            '/#\{Author_Email\}/',
                            '/#\{Copyright\}/',
                            '/#\{License\}/'
                        ), array(
                            $themeName,
                            $themeNamespace,
                            $themeFilename,
                            strtolower($themeNamespace),
                            $themeAuthor,
                            $themeAuthorEmail,
                            $themeCopyright,
                            $themeLicense
                        ), $fileContent);
        
                        fwrite($fp, $fileContent, strlen($fileContent));
                        fclose($fp);
                    }
                }

                if(preg_match('/\{theme-name\}/', $filePathName)) {
                    $newFilePathName = preg_replace('/\{theme-name\}/', $themeFilename, $filePathName);
                    
                    echo $newFilePathName;

                    if(rename($filePathName, $newFilePathName)) {
                        echo "\033[0;32m SUCCESS\033[0m\n";
                    }else {
                        echo "\033[0;31m FAIL\033[0m\n";
                    }
                }
            }
        }
    }
}