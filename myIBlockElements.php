<? require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

if(!\Bitrix\Main\Loader::includeModule('iblock')) {
	
	die('Module Iblock not found');
}


class myIBlockElements {
	
	public function cacheableGetElementsList($arOrder = array('SORT' => 'ASC'), $arFilter = array(), $arGroupBy = false, $arNavStartParams = false, $arSelectFields = array(), $cacheTime = false) {
		
		$cacheTime = (int) $cacheTime;
		
		if($cacheTime > 0) {
			
			$arAllParams = array(
			
				'ORDER' => $arOrder,
				'FILTER' => $arFilter,
				'GROUP' => $arGroupBy,
				'NAV' => $arNavStartParams,
				'SELECT' => $arSelectFields,
			);
			
			$cacheId = md5(serialize($arAllParams));
			$cache = Bitrix\Main\Data\Cache::createInstance();
			 
			if($cache->initCache($cacheTime, $cacheId)) {

				$arResult = $cache->getVars(); 
				
			} elseif($cache->startDataCache()) { 

				$arResult = $this->getElementsList($arOrder, $arFilter, $arGroupBy, $arNavStartParams, $arSelectFields); 
				$cache->endDataCache($arResult); 
			}

		} else {
			
			$arResult = $this->getElementsList($arOrder, $arFilter, $arGroupBy, $arNavStartParams, $arSelectFields); 
		}
		
		return $arResult;
	}
	
	public function getElementsList($arOrder = array('SORT' => 'ASC'), $arFilter = array(), $arGroupBy = false, $arNavStartParams = false, $arSelectFields = array()) {
		
		$arResult = array();
		$res = CIBlockElement::GetList($arOrder, $arFilter, $arGroupBy, $arNavStartParams, $arSelectFields);
		
		while($ob = $res->GetNextElement()) {
			
			$arFields = $ob->GetFields();
			
			if(in_array('PROPERTY_*', $arSelectFields)) {
				
				$arFields['PROPERTIES'] = $ob->GetProperties();
			}
			
			$arResult[] = $arFields;
		}
		
		return $arResult;
	}
}

?>