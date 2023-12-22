//부서 관련 query_부서일정
//최상위부서가 같으면 모든 일정이 보이도록
	function getDeptSCHQuery($dept, $cpn_code ,$submode='', $mode='')
	{
		$dept_sql = "";


		if(!empty($dept))
		{
			//부서코드
			$str = $dept;
			$strlen = (strlen($dept)/2);


			if($mode=="cal") $dept_sql = " or ( (TSH.cpn_code='".$cpn_code."' or TSS.cpn_code='".$tcpn_code."' ) and  (";
			else $dept_sql = " ( (TSH.cpn_code='".$cpn_code."' or TSS.cpn_code='".$cpn_code."' ) and (";

			// 부서일정 열람권한 설정 (default '0' : ,'1','2') // BMS:50634
			if($GLOBALS['GA_CONFIG']['CUSTOM']['SCH']['SCH_DEPT_LOW_AUTH'] === 2)
			{
				$deptText = substr($dept,0,2);

				$dept_sql .= " TSD.sch_gubun_dtl like '".$deptText."%'";
			}
			else
			{
				for($i = 0; $i < $strlen; $i++)
				{
					$deptText = substr($str,0,($i+1)*2);

					//if( ($strlen - 1) > 0 ) $dept_sql .= " or ";

					if($i == ($strlen - 1))
					{
						//$dept_sql .= " or TSID.dept_no like '".$dept."%' ";
						if(($strlen - 1) == 0) $dept_sql .= " TSD.sch_gubun_dtl like '".$deptText;
						else $dept_sql .= " or TSD.sch_gubun_dtl like '".$deptText;

						// 부서일정 하위부서 열람권한 여부 설정 (default true : 권한있음/ false : 권한없음) BMS:34458
						if($GLOBALS['GA_CONFIG']['CUSTOM']['SCH']['SCH_DEPT_LOW_AUTH'] === true || 
							$GLOBALS['GA_CONFIG']['CUSTOM']['SCH']['SCH_DEPT_LOW_AUTH'] === 0)
						{
							$dept_sql .="%' ";
						}
						else
						{
							$dept_sql .="' ";
						}
					}
					else
					{
						if($i != 0) $dept_sql .= "or ";

						$dept_sql .= "  TSD.sch_gubun_dtl = '".$deptText."' ";
					}
				}
			}

			if($mode=="cal" || $submode=="300") $dept_sql .= " ))";
			else $dept_sql .= ") ) or ";

		}
		else
		{
			$dept_sql = "";
		}

		//echo $dept_sql."<br>";
		return $dept_sql;


	}