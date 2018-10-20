<?php

namespace App\Main;

/**
 * Base view class
 *
 * @package App\Main
 */
class BaseView
{
    protected $title = '';
    private $links = '';
    private $scripts = '';

    public function addCss(array $files)
    {
        foreach ($files as $file) {
            if (file_exists(PUBLIC_ROOT . $file)) {
                $this->links .= '<link type="text/css" rel="stylesheet" href="' . $this->makeUrl($file) . '" />' . "\n";
            }
        }
    }

    public function addData(array $data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public function addJS(array $files)
    {
        foreach ($files as $file) {
            if (file_exists(PUBLIC_ROOT . $file)) {
                $this->scripts .= '<script type="text/javascript" src="' . $this->makeUrl($file) . '"></script>' . "\n";
            }
        }
    }

    public function escapeHTML($string)
    {
        return (htmlentities($string, HTMLENTITIES_FLAGS, HTMLENTITIES_ENCODING, HTMLENTITIES_DOUBLE_ENCODE));
    }

    public function getCSS()
    {
        return $this->links;
    }

    public function getFile($filePath)
    {
        $fileName = VIEW_PATH . $filePath . '.php';
        if (file_exists($fileName)) {
            require $fileName;
        }
    }

    public function getJS()
    {
        return $this->scripts;
    }

    public function makeUrl($path): string
    {
        if (\is_array($path)) {
            return (APP_URL . implode('/', $path));
        }

        return (APP_URL . $path);
    }

    public function render($filePath, array $data = [])
    {
        $this->addData($data);
        $this->getFile(DEFAULT_HEADER_PATH);
        $this->getFile($filePath);
    }

    public function renderMultiple(array $filePaths, array $data = [])
    {
        $this->addData($data);
        $this->getFile(DEFAULT_HEADER_PATH);
        foreach ($filePaths as $filePath) {
            $this->getFile($filePath);
        }
    }
}