<?php

namespace Only\Site\Agents;


class Iblock
{
    public static function clearOldLogs()
    {
        $IbRes = CIBlock::GetList(array(), array('IBLOCK_CODE' => 'LOG'));
        $Ib = $IbRes->Fetch();

        $res = CIBlockElement::GetList(array("ID" => "DESC"), array('IBLOCK_ID' => $Ib["ID"]));

        $ArrLog = [];

        while ($ob = $res->GetNextElement()) {
            $Fileds = $ob->GetFields();
            array_push($ArrLog, $Fileds);
        }

        $ID = [];

        foreach ($ArrLog as $value) {
            array_push($ID, $value["ID"]);
        }
        foreach ($ID as $key => $value) {
            if ($key > 9) {
                CIBlockElement::Delete($value);
            }
        }
        return "clearOldLogs();";
    }

    public static function example()
    {
        global $DB;
        if (\Bitrix\Main\Loader::includeModule('iblock')) {
            $iblockId = \Only\Site\Helpers\IBlock::getIblockID('QUARRIES_SEARCH', 'SYSTEM');
            $format = $DB->DateFormatToPHP(\CLang::GetDateFormat('SHORT'));
            $rsLogs = \CIBlockElement::GetList(['TIMESTAMP_X' => 'ASC'], [
                'IBLOCK_ID' => $iblockId,
                '<TIMESTAMP_X' => date($format, strtotime('-1 months')),
            ], false, false, ['ID', 'IBLOCK_ID']);
            while ($arLog = $rsLogs->Fetch()) {
                \CIBlockElement::Delete($arLog['ID']);
            }
        }
        return '\\' . __CLASS__ . '::' . __FUNCTION__ . '();';
    }
}
