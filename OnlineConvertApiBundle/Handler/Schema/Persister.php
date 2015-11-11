<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 11/11/2015
 * Time: 21:43
 */

namespace Aacp\OnlineConvertApiBundle\Handler\Schema;


use Aacp\OnlineConvertApiBundle\Helper\Common;
use Symfony\Component\Filesystem\Exception\ExceptionInterface;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class Persister implements PersisterInterface
{
    const SCHEMA_PATH = __DIR__ . '/../../Resources/config/schema/';

    const TIME_TO_UPDATE = 1;

    const NAME_SCHEMA_SEPARATOR = '|';

    const SCHEMA_PATH_PATTERN = self::SCHEMA_PATH . '%s.%s';

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var Finder
     */
    private $finder;

    public function __construct()
    {
        $this->filesystem = new Filesystem();
        $this->finder = new Finder();
    }

    public function getSchema($name, $data)
    {
        $this->checkSchema($name);

        try {
            $now = new \DateTime('now');
            $pathSchema = sprintf(Common::systemSlash(self::SCHEMA_PATH_PATTERN), $name, $now->getTimestamp());
            $this->filesystem->touch($pathSchema);
            $this->filesystem->dumpFile($pathSchema, $data);
        } catch (ExceptionInterface $e) {
            //todo log
            return false;
        } catch (IOExceptionInterface $e) {
            //todo log
            return false;
        }

        return $pathSchema;
    }

    private function checkSchema($name)
    {
        $schema = $this->finder->files()->in(Common::systemSlash(self::SCHEMA_PATH))->name($name . '.*');
        $now = new \DateTime('now');
        /** @var SplFileInfo $file */
        foreach ($schema as $file) {
            $fileName = $file->getBasename();
            $fileNameSplited = preg_split('/\./', $file->getBasename());
            $timestamp = $fileNameSplited[count($fileNameSplited) - 1];
            $lastTime = new \DateTime();
            $lastTime->setTimestamp($timestamp);
            $timeInterval = $lastTime->diff($now)->format('%s');
            if ($timeInterval > 1) {
                $this->filesystem->remove(Common::systemSlash(self::SCHEMA_PATH) . $fileName);
            }
        }

        return true;
    }
}