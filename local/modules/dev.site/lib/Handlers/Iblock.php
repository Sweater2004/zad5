<?php

//namespace Only\Site\Handlers;

\Bitrix\Main\Loader::includeModule('iblock');
AddEventHandler("iblock", "OnAfterIBlockElementAdd", array("Iblock", "addLog"));
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", array("Iblock", "UpLog"));
class Iblock
{
    public function addLog(&$arFields)
    {
        $IbRes = CIBlock::GetList(array(), array('ID' => $arFields["IBLOCK_ID"]));
        $Ib = $IbRes->Fetch();

        $IbSecRes = CIBlockSection::GetList(array(), array('ID' => $arFields["IBLOCK_SECTION"][0]));
        $IbSec = $IbSecRes->Fetch();

        if ($Ib['IBLOCK_CODE '] != "LOG") {
            if ($arFields["ID"] > 0) {
                $CibGet = CIBlock::GetList(array(), array('IBLOCK_CODE ' => "LOG"));
                $CibGetList = $CibGet->Fetch();

                if ($CibGetList['ID'] > 0) {

                    $Cibseck = CIBlockSection::GetList(array(), array('NAME' => '[' . $Ib['ID'] . '] ' . $Ib['NAME']));
                    $CibSeckGet = $Cibseck->Fetch();

                    if ($CibSeckGet["ID"] == 0) {
                        $CIBlockSection = new CIBlockSection;
                        $CIBlockSection = array(
                            "ACTIVE" => "Y",
                            "IBLOCK_ID" => $CibGetList['ID'],
                            "NAME" => '[' . $Ib['ID'] . '] ' . $Ib['NAME']

                        );
                        $Cibseck = CIBlockSection::GetList(array(), array('NAME' => '[' . $Ib['ID'] . '] ' . $Ib['NAME']));
                        $CibSeckGet = $Cibseck->Fetch();
                    }

                    $CibEl = new CIBlockElement;

                    $Array = array(


                        "IBLOCK_SECTION_ID" => $CibSeckGet["ID"],
                        "IBLOCK_ID"      => $CibGetList['ID'],
                        "NAME"           => $arFields["ID"],
                        "ACTIVE"         => "Y",
                        "PREVIEW_TEXT"   => $Ib['NAME'] . " -> " . $IbSec["NAME"] . " -> " . $arFields["NAME"],
                        "DETAIL_TEXT"    => $Ib['NAME'] . " -> " . $IbSec["NAME"] . " -> " . $arFields["NAME"],
                        "ACTIVE_FROM" => date("d.m.Y H:i:s"),

                    );
                    if ($PRODUCT_ID = $CibEl->Add($Array))
                        echo "New ID: " . $PRODUCT_ID;
                    else
                        echo "Error: " . $CibEl->LAST_ERROR;
                }
            }
        }
    }


    public function UpLog(&$arFields)
    {

        $IbRes = CIBlock::GetList(array(), array('ID' => $arFields["IBLOCK_ID"]));
        $Ib = $IbRes->Fetch();

        $IbSecRes = CIBlockSection::GetList(array(), array('ID' => $arFields["IBLOCK_SECTION"][0]));
        $IbSec = $IbSecRes->Fetch();

        if ($Ib['IBLOCK_CODE '] != "LOG") {
            if ($arFields["ID"] > 0) {
                $CibGet = CIBlock::GetList(array(), array('IBLOCK_CODE ' => "LOG"));
                $CibGetList = $CibGet->Fetch();

                if ($CibGetList['ID'] > 0) {

                    $Cibseck = CIBlockSection::GetList(array(), array('NAME' => '[' . $Ib['ID'] . '] ' . $Ib['NAME']));
                    $CibSeckGet = $Cibseck->Fetch();

                    if ($CibSeckGet["ID"] == 0) {
                        $CIBlockSection = new CIBlockSection;
                        $CIBlockSection = array(
                            "ACTIVE" => "Y",
                            "IBLOCK_ID" => $CibGetList['ID'],
                            "NAME" => '[' . $Ib['ID'] . '] ' . $Ib['NAME']

                        );
                        $Cibseck = CIBlockSection::GetList(array(), array('NAME' => '[' . $Ib['ID'] . '] ' . $Ib['NAME']));
                        $CibSeckGet = $Cibseck->Fetch();
                    }

                    $CibEl = new CIBlockElement;

                    $Array = array(


                        "IBLOCK_SECTION_ID" => $CibSeckGet["ID"],
                        "IBLOCK_ID"      => $CibGetList['ID'],
                        "NAME"           =>  $arFields["ID"],
                        "ACTIVE"         => "Y",
                        "PREVIEW_TEXT"   =>  $Ib['NAME'] . " -> " . $IbSec["NAME"] . " -> " . $arFields["NAME"] . "?",
                        "DETAIL_TEXT"    =>  $Ib['NAME'] . " -> " . $IbSec["NAME"] . " -> " . $arFields["NAME"] . "?",
                        "ACTIVE_FROM" => date("d.m.Y H:i:s"),

                    );
                    $PRODUCT_ID = $CibEl;
                    $res = $CibEl->Update($PRODUCT_ID, $Array);
                }
            }
        }
    }

    //function OnBeforeIBlockElementAddHandler(&$arFields)
    //{
    //    $iQuality = 95;
    //    $iWidth = 1000;
    //    $iHeight = 1000;
    //    /*
    //     * Получаем пользовательские свойства
    //     */
    //    $dbIblockProps = \Bitrix\Iblock\PropertyTable::getList(array(
    //        'select' => array('*'),
    //        'filter' => array('IBLOCK_ID' => $arFields['IBLOCK_ID'])
    //    ));
    //    /*
    //     * Выбираем только свойства типа ФАЙЛ (F)
    //     */
    //    $arUserFields = [];
    //    while ($arIblockProps = $dbIblockProps->Fetch()) {
    //        if ($arIblockProps['PROPERTY_TYPE'] == 'F') {
    //            $arUserFields[] = $arIblockProps['ID'];
    //        }
    //    }
    //    /*
    //     * Перебираем и масштабируем изображения
    //     */
    //    foreach ($arUserFields as $iFieldId) {
    //        foreach ($arFields['PROPERTY_VALUES'][$iFieldId] as &$file) {
    //            if (!empty($file['VALUE']['tmp_name'])) {
    //                $sTempName = $file['VALUE']['tmp_name'] . '_temp';
    //                $res = \CAllFile::ResizeImageFile(
    //                    $file['VALUE']['tmp_name'],
    //                    $sTempName,
    //                    array("width" => $iWidth, "height" => $iHeight),
    //                    BX_RESIZE_IMAGE_PROPORTIONAL_ALT,
    //                    false,
    //                    $iQuality
    //                );
    //                if ($res) {
    //                    rename($sTempName, $file['VALUE']['tmp_name']);
    //                }
    //            }
    //        }
    //    }
    //
    //    if ($arFields['CODE'] == 'brochures') {
    //        $RU_IBLOCK_ID = \Only\Site\Helpers\IBlock::getIblockID('DOCUMENTS', 'CONTENT_RU');
    //        $EN_IBLOCK_ID = \Only\Site\Helpers\IBlock::getIblockID('DOCUMENTS', 'CONTENT_EN');
    //        if ($arFields['IBLOCK_ID'] == $RU_IBLOCK_ID || $arFields['IBLOCK_ID'] == $EN_IBLOCK_ID) {
    //            \CModule::IncludeModule('iblock');
    //            $arFiles = [];
    //            foreach ($arFields['PROPERTY_VALUES'] as $id => &$arValues) {
    //                $arProp = \CIBlockProperty::GetByID($id, $arFields['IBLOCK_ID'])->Fetch();
    //                if ($arProp['PROPERTY_TYPE'] == 'F' && $arProp['CODE'] == 'FILE') {
    //                    $key_index = 0;
    //                    while (isset($arValues['n' . $key_index])) {
    //                        $arFiles[] = $arValues['n' . $key_index++];
    //                    }
    //                } elseif ($arProp['PROPERTY_TYPE'] == 'L' && $arProp['CODE'] == 'OTHER_LANG' && $arValues[0]['VALUE']) {
    //                    $arValues[0]['VALUE'] = null;
    //                    if (!empty($arFiles)) {
    //                        $OTHER_IBLOCK_ID = $RU_IBLOCK_ID == $arFields['IBLOCK_ID'] ? $EN_IBLOCK_ID : $RU_IBLOCK_ID;
    //                        $arOtherElement = \CIBlockElement::GetList(
    //                            [],
    //                            [
    //                                'IBLOCK_ID' => $OTHER_IBLOCK_ID,
    //                                'CODE' => $arFields['CODE']
    //                            ],
    //                            false,
    //                            false,
    //                            ['ID']
    //                        )
    //                            ->Fetch();
    //                        if ($arOtherElement) {
    //                            /** @noinspection PhpDynamicAsStaticMethodCallInspection */
    //                            \CIBlockElement::SetPropertyValues($arOtherElement['ID'], $OTHER_IBLOCK_ID, $arFiles, 'FILE');
    //                        }
    //                    }
    //                } elseif ($arProp['PROPERTY_TYPE'] == 'E') {
    //                    $elementIds = [];
    //                    foreach ($arValues as &$arValue) {
    //                        if ($arValue['VALUE']) {
    //                            $elementIds[] = $arValue['VALUE'];
    //                            $arValue['VALUE'] = null;
    //                        }
    //                    }
    //                    if (!empty($arFiles && !empty($elementIds))) {
    //                        $rsElement = \CIBlockElement::GetList(
    //                            [],
    //                            [
    //                                'IBLOCK_ID' => \Only\Site\Helpers\IBlock::getIblockID('PRODUCTS', 'CATALOG_' . $RU_IBLOCK_ID == $arFields['IBLOCK_ID'] ? '_RU' : '_EN'),
    //                                'ID' => $elementIds
    //                            ],
    //                            false,
    //                            false,
    //                            ['ID', 'IBLOCK_ID', 'NAME']
    //                        );
    //                        while ($arElement = $rsElement->Fetch()) {
    //                            /** @noinspection PhpDynamicAsStaticMethodCallInspection */
    //                            \CIBlockElement::SetPropertyValues($arElement['ID'], $arElement['IBLOCK_ID'], $arFiles, 'FILE');
    //                        }
    //                    }
    //                }
    //            }
    //        }
    //    }
    //}
}
