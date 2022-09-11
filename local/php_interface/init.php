<?
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/local/modules/test_module/include/event_handler.php")) {
    include_once($_SERVER['DOCUMENT_ROOT'] . "/local/modules/test_module/include/event_handler.php");
}
AddEventHandler("iblock", "OnAfterIBlockElementAdd", array("Iblock", "addLog"));
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", array("Iblock", "updateLog"));
\Bitrix\Main\Loader::includeModule('iblock');
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/modules/devsite/lib/Agents/Iblock.php")) {
    require_once($_SERVER["DOCUMENT_ROOT"] . "/local/modules/devsite/lib/Agents/Iblock.php");
}
CAgent::AddAgent("Iblock::clearOldLogs();", "", "N", "3600", "", "Y", "12.09.2022 04:55");
