<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   Modules\ContractManagement\Admin
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\ContractManagement\Admin;

use phpOMS\Application\ApplicationAbstract;
use phpOMS\Config\SettingsInterface;
use phpOMS\Message\Http\HttpRequest;
use phpOMS\Message\Http\HttpResponse;
use phpOMS\Module\InstallerAbstract;
use phpOMS\Module\ModuleInfo;
use phpOMS\Uri\HttpUri;

/**
 * Installer class.
 *
 * @package Modules\ContractManagement\Admin
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
final class Installer extends InstallerAbstract
{
    /**
     * Path of the file
     *
     * @var string
     * @since 1.0.0
     */
    public const PATH = __DIR__;

    /**
     * {@inheritdoc}
     */
    public static function install(ApplicationAbstract $app, ModuleInfo $info, SettingsInterface $cfgHandler) : void
    {
        parent::install($app, $info, $cfgHandler);

        /* Bill types */
        $fileContent = \file_get_contents(__DIR__ . '/Install/types.json');
        if ($fileContent === false) {
            return;
        }

        /** @var array $types */
        $types = \json_decode($fileContent, true);
        if ($types === false) {
            return;
        }

        self::createContractTypes($app, $types);
    }

    /**
     * Install default contract types
     *
     * @param ApplicationAbstract $app   Application
     * @param array               $types Bill types
     *
     * @return array
     *
     * @since 1.0.0
     */
    private static function createContractTypes(ApplicationAbstract $app, array $types) : array
    {
        $contractTypes = [];

        /** @var \Modules\ContractManagement\Controller\ApiContractTypeController $module */
        $module = $app->moduleManager->getModuleInstance('ContractManagement', 'ApiContractType');

        foreach ($types as $type) {
            $response = new HttpResponse();
            $request  = new HttpRequest(new HttpUri(''));

            $request->header->account = 1;
            $request->setData('name', $type['name'] ?? '');
            $request->setData('title', \reset($type['l11n']));
            $request->setData('language', \array_keys($type['l11n'])[0] ?? 'en');

            $module->apiContractTypeCreate($request, $response);

            $responseData = $response->get('');
            if (!\is_array($responseData)) {
                continue;
            }

            $billType = \is_array($responseData['response'])
                ? $responseData['response']
                : $responseData['response']->toArray();

            $contractTypes[] = $billType;

            $isFirst = true;
            foreach ($type['l11n'] as $language => $l11n) {
                if ($isFirst) {
                    $isFirst = false;
                    continue;
                }

                $response = new HttpResponse();
                $request  = new HttpRequest(new HttpUri(''));

                $request->header->account = 1;
                $request->setData('title', $l11n);
                $request->setData('language', $language);
                $request->setData('type', $billType['id']);

                $module->apiContractTypeL11nCreate($request, $response);
            }
        }

        return $contractTypes;
    }
}
