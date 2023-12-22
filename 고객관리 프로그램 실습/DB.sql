-- CREATE TABLE IF NOT EXISTS `C_CUSTOMER_CPN` (
--   `cpn_no` int(11) NOT NULL AUTO_INCREMENT,
--   `acc_no` int(11) NOT NULL COMMENT `작성자`,
--   `cpn_code` char(2) NOT NULL COMMENT `계열사코드`,
--   `cpn_name` varchar(50) NOT NULL,
--   `bus_regi_num` varchar(50) NOT NULL COMMENT `사업자번호`,
--   `corporate_regi_num` varchar(50) NOT NULL COMMENT `법인번호`,
--   `bus_type` varchar(50) NOT NULL COMMENT `업태`,
--   `bus_category` varchar(50) NOT NULL COMMENT `업종`,
--   `ceo_name` varchar(30) NOT NULL,
--   `ceo_tel` varchar(50) NOT NULL,
--   `fax` varchar(50) NULL,
--   `phone_num` varchar(50) NOT NULL,
--   `email` varchar(255) NOT NULL,
--   `homepage_url` varchar(255) NULL,
--   `cpn_addr` varchar(150) NOT NULL,
--   `comment` varchar(1000) NULL COMMENT `비고`,
--   `reg_dt` datetime NOT NULL,
--   `del_dt` datetime NULL,
--   PRIMARY KEY (`cpn_no`)
-- ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
-- COMMENT 다니까 에러남 왜???????


-- 고유번호
-- 상호(업체)
-- 사업자번호
-- 법인번호
-- 업태
-- 업종
-- 대표자명
-- 대표전화
-- FAX
-- 휴대폰
-- 이메일
-- 홈페이지
-- 주소
-- 비고
-- 계열사 코드
-- 작성자
-- 작성, 삭제 일자

-- 게시판참고

USE `TOP_BASE_DB`;

CREATE TABLE IF NOT EXISTS `C_CUSTOMER_CPN` (
  `cpn_no` int(11) NOT NULL AUTO_INCREMENT,
  `acc_no` int(11) NOT NULL,
  `cpn_code` char(2) NOT NULL,
  `cpn_name` varchar(50) NOT NULL,
  `bus_regi_num` varchar(50) NOT NULL,
  `corporate_regi_num` varchar(50) NOT NULL,
  `bus_type` varchar(50) NOT NULL,
  `bus_category` varchar(50) NOT NULL,
  `ceo_name` varchar(30) NOT NULL,
  `ceo_tel` varchar(50) NOT NULL,
  `fax` varchar(50) NULL,
  `phone_num` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `homepage_url` varchar(255) NULL,
  `cpn_addr` varchar(150) NOT NULL,
  `comment` varchar(1000) NULL,
  `reg_dt` datetime NOT NULL,
  `del_dt` datetime NULL,
  PRIMARY KEY (`cpn_no`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- INSERT INTO `C_CUSTOMER_CPN` (`acc_no`,`cpn_code`,`cpn_name`,`bus_regi_num`, `corporate_regi_num`, `bus_type`, `bus_category`, `ceo_name`, `ceo_tel`, `fax`, `phone_num`, 
-- `email`, `homepage_url`, `cpn_addr`, `comment`, `reg_dt`) 
-- VALUES (1, `CA`, `테스트`, `1111`, `1111`, `테스트1`, `테스트2`, `아무개`, `01012345678`, `012345678`, `01087654321`, `test@test.com`, `test.test.com`, `주소`, `비고란테스트`, NOW());

