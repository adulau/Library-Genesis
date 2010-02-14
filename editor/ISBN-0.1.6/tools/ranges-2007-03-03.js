/*
 Range definitions.
 Every valid group number must be included in the Array of gi.idarr
 and has its object containing the text and the valid ranges

 Be sure to save a backup of the old version before doing any changes
 Note your changes in revision history

--------------------------------------------------------------------------------------
Revision history:

22.6.2005: Version delivered by Leitess
-----
21.02.2007; Changed Zambia (9982) "00-79;800-989;9900-9999"
20.02.2007; Added Kazakhstan (601) "00-19;200-699;7000-7999;80000-84999;85-99"
01.02.2007; Changed Jordan (9957) "00-39;400-699;70-84;8500-9999"
09.01.2007; Changed Iceland (9979) "0-4;50-64;650-659;66-75;760-899;9000-9999"
05.01.2007; Changed Croatia (953) "0-0;10-14;150-549;55000-59999;6000-9499;95000-99999"
22.12.2006; Changed Dominican Republic (9945) "00-00;010-079;08-39;400-569;57-57;580-849;8500-9999";
20.12.2006; Added ranges for Palestine (9950) "00-29;300-840;8500-9999"
11.12.2006; Changed Serbia (86) "00-09;10-29;300-599;6000-7999;80000-89999;900000-999999";)
05.12.2006; Added Iran (600) 00-09;100-499;5000-8999;90000-99999
05.12.2006; Added Montenegro (9940) 0-1;20-49;500-899;9000-9999 
05.12.2006; Added Georgia (9941) 0-0;10-39;400-899;9000-9999 
20.11.2006; Changed Haiti (99935) 0-2;7-8;30-59;600-699;90-99
02.11.2006; Changed Ukraine (966) 00-19;2000-2999;300-699;700-8999;90000-99999
12.10.2006; Changed Turkey (9944) 0-2;300-499;5000-5999;60-89;900-999
11.10.2006; Corrected Nicaragua (99924) from 800 - 900 to 800-999
22.09.2006; Added Ecuador (9942) 00-89; 900-994; 9950-9999
15.09.2006; Added Uzbekistan (9943) 00-29; 300-399; 4000-9999
14.09.2006; Corrected Russia (5) 9909999 etc
07.09.2006: Corrected Greece (960) adding 7000-8499
21.08.2006: Altered Armenia (99941): 30-79; 800-999  
30.07.2006: Altered Romania (973) 100-169;1700-1999
30.05.2006: Added: Bolivia (99954); 0-2;30-69;700-999; Srpska (99955); 0-1; 20-59;600-899;90-99
03.05.2006: Changed all 00-nn ranges to 00-09;10-nn
24.01.2006: Altered: Iran (964); 00-14;150-249;2500-2999; Moldova (9975) 0;100-399;4000-4499;45-89
23.01.2006: Added: Turkey (9944) 0-5; 60-89: 900-999; Paraguay (99953) 0-2; 30-79; 800-999; Altered: Romania (973) 0; 100-199
16.01.2006: Added: Algeria (9961) 0-2
Altered:gi.area9961.pubrange="0-2;11.01.2006: Added: Indonesia (979) 000-099;1000-1499;15000-19999
21.11.2005: Added: Mali (99952) 0-4;50-79;800-999
16.11.2005: Altered: Romania (973) 85000-88999; 8900-9499; Added: Tajikistan (99947) 0-2; 30-69; 700-999
14.11.2005: Altered: Srpska (99938) 0-1;20-59; Added: Mongolia (99929) 0-4; 50-79; 800-999
26.10.2005: Altered: Botswana (99912) 0-3;400-599
24.8.2005: Corrected: Finland (952) 80-94
17.8.2005: Added: South Pacific (982) 00-09
12.8.2005: Added:
Cambodia (99950) 0-4, 50-79, 800-999
Altered:Srpska (99938) 600-999 changed to 600-899, 90-99
18.7.2005: Altered:
Italy (88) 900000-999999 changed to 900000-949999, 95000-99999
23.6.2005: Added / altered:
Russia (5) 9910-9999
Turkey (975) 00000 - 00999, 990-999 (& changed 00-24 to 01-24)
Argentina (987) 00-09
Kuwait (99906) 0-2, 70-89, 9-9
-----
*/



// ID List:
gi = new Object;
gi.idarr  = new Array(0,1,2,3,4,5,600,601,7,80,81,82,83,84,85,86,87,88,89,90,91,92,93,950,951,952,953,954,955,956,957,958,959,960,961,962,963,964,965,966,967,968,969,970,971,972,973,974,975,976,977,978,979,980,981,982,983,984,985,986,987,988,989,9940,9941,9942,9943,9944,9945,9946,9947,9948,9949,9950,9951,9952,9953,9954,9955,9956,9957,9958,9959,9960,9961,9962,9963,9964,9965,9966,9967,9968,9970,9971,9972,9973,9974,9975,9976,9977,9978,9979,9980,9981,9982,9983,9984,9985,9986,9987,9988,9989,99901,99902,99903,99904,99905,99906,99908,99909,99910,99911,99912,99913,99914,99915,99916,99917,99918,99919,99920,99921,99922,99923,99924,99925,99926,99927,99928,99929,99930,99931,99932,99933,99934,99935,99936,99937,99938,99939,99940,99941,99942,99943,99944,99945,99946,99947,99948,99949,99950,99951,99952,99953,99954,99955);
gi.idlist = ',' + gi.idarr.toString() + ',';

// ID objects:

gi.area0 = new Object;
gi.area0.text="English speaking area";
gi.area0.pubrange="00-19;200-699;7000-8499;85000-89999;900000-949999;9500000-9999999";

gi.area1 = new Object;
gi.area1.text="English speaking area";
gi.area1.pubrange="00-09;100-399;4000-5499;55000-86979;869800-998999";

gi.area2 = new Object;
gi.area2.text="French speaking area";
gi.area2.pubrange="00-19;200-349;35000-39999;400-699;7000-8399;84000-89999;900000-949999;9500000-9999999";

gi.area3 = new Object;
gi.area3.text="German speaking area";
gi.area3.pubrange="00-02;030-033;0340-0369;03700-03999;04-19;200-699;7000-8499;85000-89999;900000-949999;9500000-9999999";

gi.area4 = new Object;
gi.area4.text="Japan";
gi.area4.pubrange="00-19;200-699;7000-8499;85000-89999;900000-949999;9500000-9999999";

gi.area5 = new Object;
gi.area5.text="Russian Federation";
gi.area5.pubrange="00-19;200-699;7000-8499;85000-89999;900000-909999;91000-91999;9200-9299;93000-94999;9500-9799;98000-98999;9900000-9909999;9910-9999";

gi.area600 = new Object;
gi.area600.text = "Iran"
gi.area600.pubrange="00-09;100-499;5000-8999;90000-99999"

gi.area601 = new Object;
gi.area601.text = "Kazakhstan"
gi.area601.pubrange="00-19;200-699;7000-7999;80000-84999;85-99"

gi.area7 = new Object;
gi.area7.text="China, People's Republic";
gi.area7.pubrange="00-09;100-499;5000-7999;80000-89999;900000-999999";

gi.area80 = new Object;
gi.area80.text="Czech Republic; Slovakia";
gi.area80.pubrange="00-19;200-699;7000-8499;85000-89999;900000-999999";

gi.area81 = new Object;
gi.area81.text="India";
gi.area81.pubrange="00-19;200-699;7000-8499;85000-89999;900000-999999";

gi.area82 = new Object;
gi.area82.text="Norway";
gi.area82.pubrange="00-19;200-699;7000-8999;90000-98999;990000-999999";

gi.area83 = new Object;
gi.area83.text="Poland";
gi.area83.pubrange="00-19;200-599;60000-69999;7000-8499;85000-89999;900000-999999";

gi.area84 = new Object;
gi.area84.text="Spain";
gi.area84.pubrange="00-19;200-699;7000-8499;85000-89999;9000-9199;920000-923999;92400-92999;930000-949999;95000-96999;9700-9999";

gi.area85 = new Object;
gi.area85.text="Brazil";
gi.area85.pubrange="00-19;200-599;60000-69999;7000-8499;85000-89999;900000-979999;98000-99999";

gi.area86 = new Object;
gi.area86.text="Serbia and Montenegro";
gi.area86.pubrange="00-29;300-599;6000-7999;80000-89999;900000-999999";

gi.area87 = new Object;
gi.area87.text="Denmark";
gi.area87.pubrange="00-29;400-649;7000-7999;85000-94999;970000-999999";

gi.area88 = new Object;
gi.area88.text="Italian speaking area";
gi.area88.pubrange="00-19;200-599;6000-8499;85000-89999;900000-949999;95000-99999";

gi.area89 = new Object;
gi.area89.text="Korea";
gi.area89.pubrange="00-24;250-549;5500-8499;85000-94999;950000-999999";

gi.area90 = new Object;
gi.area90.text="Netherlands, Belgium (Flemish)";
gi.area90.pubrange="00-19;200-499;5000-6999;70000-79999;800000-849999;8500-8999;900000-909999;940000-949999";

gi.area91 = new Object;
gi.area91.text="Sweden";
gi.area91.pubrange="0-1;20-49;500-649;7000-7999;85000-94999;970000-999999";

gi.area92 = new Object;
gi.area92.text="International Publishers (Unesco, EU), European Community Organizations";
gi.area92.pubrange="0-5;60-79;800-899;9000-9499;95000-98999;990000-999999";

gi.area93 = new Object;
gi.area93.text="India - no ranges fixed yet";
gi.area93.pubrange="";

gi.area950 = new Object;
gi.area950.text="Argentina";
gi.area950.pubrange="00-49;500-899;9000-9899;99000-99999";

gi.area951 = new Object;
gi.area951.text="Finland";
gi.area951.pubrange="0-1;20-54;550-889;8900-9499;95000-99999";

gi.area952 = new Object;
gi.area952.text="Finland";
gi.area952.pubrange="00-19;200-499;5000-5999;60-65;6600-6699;67000-69999;7000-7999;80-94;9500-9899;99000-99999";

gi.area953 = new Object;
gi.area953.text="Croatia";
gi.area953.pubrange="0-0;10-14;150-549;55000-59999;6000-9499;95000-99999";

gi.area954 = new Object;
gi.area954.text="Bulgaria";
gi.area954.pubrange="00-29;300-799;8000-8999;90000-92999;9300-9999";

gi.area955 = new Object;
gi.area955.text="Sri Lanka";
gi.area955.pubrange="0-0;1000-1999;20-54;550-799;8000-9499;95000-99999";

gi.area956 = new Object;
gi.area956.text="Chile";
gi.area956.pubrange="00-19;200-699;7000-9999";

gi.area957 = new Object;
gi.area957.text="Taiwan, China";
gi.area957.pubrange="00-02;0300-0499;05-19;2000-2099;21-27;28000-30999;31-43;440-819;8200-9699;97000-99999";

gi.area958 = new Object;
gi.area958.text="Colombia";
gi.area958.pubrange="00-59;600-799;8000-9499;95000-99999";

gi.area959 = new Object;
gi.area959.text="Cuba";
gi.area959.pubrange="00-19;200-699;7000-8499";

gi.area960 = new Object;
gi.area960.text="Greece";
gi.area960.pubrange="00-19;200-659;6600-6899;690-699;7000-8499;85000-99999";

gi.area961 = new Object;
gi.area961.text="Slovenia";
gi.area961.pubrange="00-19;200-599;6000-8999;90000-94999";

gi.area962 = new Object;
gi.area962.text="Hong Kong";
gi.area962.pubrange="00-19;200-699;7000-8499;85000-86999;8700-8999;900-999";

gi.area963 = new Object;
gi.area963.text="Hungary";
gi.area963.pubrange="00-19;200-699;7000-8499;85000-89999;9000-9999";

gi.area964 = new Object;
gi.area964.text="Iran";
gi.area964.pubrange="00-14;150-249;2500-2999;300-549;5500-8999;90000-96999;970-989;9900-9999";

gi.area965 = new Object;
gi.area965.text="Israel";
gi.area965.pubrange="00-19;200-599;7000-7999;90000-99999";

gi.area966 = new Object;
gi.area966.text="Ukraine";
gi.area966.pubrange="00-19;2000-2999;300-699;7000-8999;90000-99999";

gi.area967 = new Object;
gi.area967.text="Malaysia";
gi.area967.pubrange="0-5;60-89;900-989;9900-9989;99900-99999";

gi.area968 = new Object;
gi.area968.text="Mexico";
gi.area968.pubrange="01-39;400-499;5000-7999;800-899;9000-9999";

gi.area969 = new Object;
gi.area969.text="Pakistan";
gi.area969.pubrange="0-1;20-39;400-799;8000-9999";


gi.area970 = new Object;
gi.area970.text="Mexico";
gi.area970.pubrange="01-59;600-899;9000-9099;91000-96999;9700-9999";

gi.area971 = new Object;
gi.area971.text="Philippines?";
gi.area971.pubrange="000-019;02-02;0300-0599;06-09;10-49;500-849;8500-9099;91000-99999";

gi.area972 = new Object;
gi.area972.text="Portugal";
gi.area972.pubrange="0-1;20-54;550-799;8000-9499;95000-99999";

gi.area973 = new Object;
gi.area973.text="Romania";
gi.area973.pubrange="0-0;100-169;1700-1999;20-54;550-759;7600-8499;85000-88999;8900-9499;95000-99999";

gi.area974 = new Object;
gi.area974.text="Thailand";
gi.area974.pubrange="00-19;200-699;7000-8499;85000-89999;90000-94999;9500-9999";

gi.area975 = new Object;
gi.area975.text="Turkey";
gi.area975.pubrange="00000-00999;01-24;250-599;6000-9199;92000-98999;990-999";

gi.area976 = new Object;
gi.area976.text="Caribbean Community";
gi.area976.pubrange="0-3;40-59;600-799;8000-9499;95000-99999";

gi.area977 = new Object;
gi.area977.text="Egypr";
gi.area977.pubrange="00-19;200-499;5000-6999;700-999";

gi.area978 = new Object;
gi.area978.text="Nigeria";
gi.area978.pubrange="000-199;2000-2999;30000-79999;8000-8999;900-999";

gi.area979 = new Object;
gi.area979.text="Indonesia";
gi.area979.pubrange="000-099;1000-1499;15000-19999;20-29;3000-3999;400-799;8000-9499;95000-99999";

gi.area980 = new Object;
gi.area980.text="Venezuela";
gi.area980.pubrange="00-19;200-599;6000-9999";

gi.area981 = new Object;
gi.area981.text="Singapore";
gi.area981.pubrange="00-19;200-299;3000-9999";

gi.area982 = new Object;
gi.area982.text="South Pacific";
gi.area982.pubrange="00-09;100-699;70-89;9000-9999";

gi.area983 = new Object;
gi.area983.text="Malaysia";
gi.area983.pubrange="00-01;020-199;2000-3999;40000-49999;50-79;800-899;9000-9899;99000-99999";

gi.area984 = new Object;
gi.area984.text="Bangladesh";
gi.area984.pubrange="00-39;400-799;8000-8999;90000-99999";

gi.area985 = new Object;
gi.area985.text="Belarus";
gi.area985.pubrange="00-39;400-599;6000-8999;90000-99999";

gi.area986 = new Object;
gi.area986.text="Taiwan, China";
gi.area986.pubrange="00-11;120-559;5600-7999;80000-99999";

gi.area987 = new Object;
gi.area987.text="Argentina";
gi.area987.pubrange="00-09;1000-1999;20000-29999;30-49;500-899;9000-9499;95000-99999";

gi.area988 = new Object;
gi.area988.text="Hongkong";
gi.area988.pubrange="00-19;200-799;8000-9699;97000-99999";

gi.area989 = new Object;
gi.area989.text="Portugal";
gi.area989.pubrange="0-1;20-54;550-799;8000-9499;95000-99999";

gi.area9940 = new Object;
gi.area9940.text="Montenegro";
gi.area9940.pubrange="0-1;20-49;500-899;9000-9999"

gi.area9941 = new Object;
gi.area9941.text="Georgia";
gi.area9941.pubrange="0-0;10-39;400-899;9000-9999"

gi.area9942 = new Object;
gi.area9942.text="Ecuador";
gi.area9942.pubrange="00-89;900-994;9950-9999";

gi.area9943 = new Object;
gi.area9943.text="Uzbekistan";
gi.area9943.pubrange="00-29;300-399;4000-9999";

gi.area9944 = new Object;
gi.area9944.text="Turkey";
gi.area9944.pubrange="0-2;300-499;5000-5999;60-89;900-999";

gi.area9945 = new Object;
gi.area9945.text="Dominican Republic";
gi.area9945.pubrange="00-00;010-079;08-39;400-569;57-57;580-849;8500-9999";

gi.area9946 = new Object;
gi.area9946.text="Korea, P.D.R.";
gi.area9946.pubrange="0-1;20-39;400-899;9000-9999";

gi.area9947 = new Object;
gi.area9947.text="Algeria";
gi.area9947.pubrange="0-1;20-79;800-999";

gi.area9948 = new Object;
gi.area9948.text="United Arab Emirates";
gi.area9948.pubrange="00-39;400-849;8500-9999";

gi.area9949 = new Object;
gi.area9949.text="Estonia";
gi.area9949.pubrange="0-0;10-39;400-899;9000-9999";

gi.area9950 = new Object;
gi.area9950.text="Palestine";
gi.area9950.pubrange="00-29;300-840;8500-9999";

gi.area9951 = new Object;
gi.area9951.text="Kosova";
gi.area9951.pubrange="00-39;400-849;8500-9999";

gi.area9952 = new Object;
gi.area9952.text="Azerbaijan";
gi.area9952.pubrange="0-1;20-39;400-799;8000-9999";

gi.area9953 = new Object;
gi.area9953.text="Lebanon";
gi.area9953.pubrange="0-0;10-39;400-599;60-89;9000-9999";

gi.area9954 = new Object;
gi.area9954.text="Morocco";
gi.area9954.pubrange="0-1;20-39;400-799;8000-9999";

gi.area9955 = new Object;
gi.area9955.text="Lithuania";
gi.area9955.pubrange="00-39;400-929;9300-9999";

gi.area9956 = new Object;
gi.area9956.text="Cameroon";
gi.area9956.pubrange="0-0;10-39;400-899;9000-9999";

gi.area9957 = new Object;
gi.area9957.text="Jordan";
gi.area9957.pubrange="00-39;400-699;70-84;8500-9999";

gi.area9958 = new Object;
gi.area9958.text="Bosnia and Herzegovina";
gi.area9958.pubrange="0-0;10-49;500-899;9000-9999";

gi.area9959 = new Object;
gi.area9959.text="Libya";
gi.area9959.pubrange="0-1;20-79;800-949;9500-9999";

gi.area9960 = new Object;
gi.area9960.text="Saudi Arabia";
gi.area9960.pubrange="00-59;600-899;9000-9999";

gi.area9961 = new Object;
gi.area9961.text="Algeria";
gi.area9961.pubrange="0-2;30-69;700-949;9500-9999";

gi.area9962 = new Object;
gi.area9962.text="Panama";
gi.area9962.pubrange="00-54;5500-5599;56-59;600-849;8500-9999";

gi.area9963 = new Object;
gi.area9963.text="Cyprus";
gi.area9963.pubrange="0-2;30-54;550-749;7500-9999";

gi.area9964 = new Object;
gi.area9964.text="Ghana";
gi.area9964.pubrange="0-6;70-94;950-999";

gi.area9965 = new Object;
gi.area9965.text="Kazakhstan";
gi.area9965.pubrange="00-39;400-899;9000-9999";

gi.area9966 = new Object;
gi.area9966.text="Kenya";
gi.area9966.pubrange="00-69;7000-7499;750-959;9600-9999";

gi.area9967 = new Object;
gi.area9967.text="Kyrgyzstan";
gi.area9967.pubrange="00-39;400-899;9000-9999";

gi.area9968 = new Object;
gi.area9968.text="Costa Rica";
gi.area9968.pubrange="00-49;500-939;9400-9999";

gi.area9970 = new Object;
gi.area9970.text="Uganda";
gi.area9970.pubrange="00-39;400-899;9000-9999";

gi.area9971 = new Object;
gi.area9971.text="Singapore";
gi.area9971.pubrange="0-5;60-89;900-989;9900-9999";

gi.area9972 = new Object;
gi.area9972.text="Peru";
gi.area9972.pubrange="00-09;1;200-249;2500-2999;30-59;600-899;9000-9999";

gi.area9973 = new Object;
gi.area9973.text="Tunisia";
gi.area9973.pubrange="0-0;10-69;700-969;9700-9999";

gi.area9974 = new Object;
gi.area9974.text="Uruguay";
gi.area9974.pubrange="0-2;30-54;550-749;7500-9499;95-99";

gi.area9975 = new Object;
gi.area9975.text="Moldova";
gi.area9975.pubrange="0;100-399;4000-4499;45-89;900-949;9500-9999";

gi.area9976 = new Object;
gi.area9976.text="Tanzania";
gi.area9976.pubrange="0-5;60-89;900-989;9990-9999";

gi.area9977 = new Object;
gi.area9977.text="Costa Rica";
gi.area9977.pubrange="00-89;900-989;9900-9999";

gi.area9978 = new Object;
gi.area9978.text="Ecuador";
gi.area9978.pubrange="00-29;300-399;40-94;950-989;9900-9999";

gi.area9979 = new Object;
gi.area9979.text="Iceland";
gi.area9979.pubrange="0-4;50-64;650-659;66-75;760-899;9000-9999";

gi.area9980 = new Object;
gi.area9980.text="Papua New Guinea";
gi.area9980.pubrange="0-3;40-89;900-989;9900-9999";

gi.area9981 = new Object;
gi.area9981.text="Morocco";
gi.area9981.pubrange="00-09;100-159;1600-1999;20-79;800-949;9500-9999";

gi.area9982 = new Object;
gi.area9982.text="Zambia";
gi.area9982.pubrange="00-79;800-989;9900-9999";

gi.area9983 = new Object;
gi.area9983.text="Gambia";
gi.area9983.pubrange="80-94;950-989;9900-9999";

gi.area9984 = new Object;
gi.area9984.text="Latvia";
gi.area9984.pubrange="00-49;500-899;9000-9999";

gi.area9985 = new Object;
gi.area9985.text="Estonia";
gi.area9985.pubrange="0-4;50-79;800-899;9000-9999";

gi.area9986 = new Object;
gi.area9986.text="Lithuania";
gi.area9986.pubrange="00-39;400-899;9000-9399;940-969;97-99";

gi.area9987 = new Object;
gi.area9987.text="Tanzania";
gi.area9987.pubrange="00-39;400-879;8800-9999";

gi.area9988 = new Object;
gi.area9988.text="Ghana";
gi.area9988.pubrange="0-2;30-54;550-749;7500-9999";

gi.area9989 = new Object;
gi.area9989.text="Macedonia";
gi.area9989.pubrange="0-0;100-199;2000-2999;30-59;600-949;9500-9999";

gi.area99901 = new Object;
gi.area99901.text="Bahrain";
gi.area99901.pubrange="00-49;500-799;80-99";

gi.area99902 = new Object;
gi.area99902.text="Gabon - no ranges fixed yet";
gi.area99902.pubrange="";

gi.area99903 = new Object;
gi.area99903.text="Mauritius";
gi.area99903.pubrange="0-1;20-89;900-999";

gi.area99904 = new Object;
gi.area99904.text="Netherlands Antilles; Aruba, Neth. Ant";
gi.area99904.pubrange="0-5;60-89;900-999";

gi.area99905 = new Object;
gi.area99905.text="Bolivia";
gi.area99905.pubrange="0-3;40-79;800-999";

gi.area99906 = new Object;
gi.area99906.text="Kuwait";
gi.area99906.pubrange="0-2;30-59;600-699;70-89;9-9";

gi.area99908 = new Object;
gi.area99908.text="Malawi";
gi.area99908.pubrange="0-0;10-89;900-999";

gi.area99909 = new Object;
gi.area99909.text="Malta";
gi.area99909.pubrange="0-3;40-94;950-999";

gi.area99910 = new Object;
gi.area99910.text="Sierra Leone";
gi.area99910.pubrange="0-2;30-89;900-999";

gi.area99911 = new Object;
gi.area99911.text="Lesotho";
gi.area99911.pubrange="00-59;600-999";

gi.area99912 = new Object;
gi.area99912.text="Botswana";
gi.area99912.pubrange="0-3;400-599;60-89;900-999";

gi.area99913 = new Object;
gi.area99913.text="Andorra";
gi.area99913.pubrange="0-2;30-35;600-604";

gi.area99914 = new Object;
gi.area99914.text="Suriname";
gi.area99914.pubrange="0-4;50-89;900-949";

gi.area99915 = new Object;
gi.area99915.text="Maldives";
gi.area99915.pubrange="0-4;50-79;800-999";

gi.area99916 = new Object;
gi.area99916.text="Namibia";
gi.area99916.pubrange="0-2;30-69;700-999";

gi.area99917 = new Object;
gi.area99917.text="Brunei Darussalam";
gi.area99917.pubrange="0-2;30-89;900-999";

gi.area99918 = new Object;
gi.area99918.text="Faroe Islands";
gi.area99918.pubrange="0-3;40-79;800-999";

gi.area99919 = new Object;
gi.area99919.text="Benin";
gi.area99919.pubrange="0-2;40-69;900-999";

gi.area99920 = new Object;
gi.area99920.text="Andorra";
gi.area99920.pubrange="0-4;50-89;900-999";

gi.area99921 = new Object;
gi.area99921.text="Qatar";
gi.area99921.pubrange="0-1;20-69;700-799;8-8;90-99";

gi.area99922 = new Object;
gi.area99922.text="Guatemala";
gi.area99922.pubrange="0-3;40-69;700-999";

gi.area99923 = new Object;
gi.area99923.text="El Salvador";
gi.area99923.pubrange="0-1;20-79;800-999";

gi.area99924 = new Object;
gi.area99924.text="Nicaragua";
gi.area99924.pubrange="0-2;30-79;800-999";

gi.area99925 = new Object;
gi.area99925.text="Paraguay";
gi.area99925.pubrange="0-3;40-79;800-999";

gi.area99926 = new Object;
gi.area99926.text="Honduras";
gi.area99926.pubrange="0-0;10-59;600-999";

gi.area99927 = new Object;
gi.area99927.text="Albania";
gi.area99927.pubrange="0-2;30-59;600-999";

gi.area99928 = new Object;
gi.area99928.text="Georgia";
gi.area99928.pubrange="0-0;10-79;800-999";

gi.area99929 = new Object;
gi.area99929.text="Mongolia";
gi.area99929.pubrange="0-4;50-79;800-999";

gi.area99930 = new Object;
gi.area99930.text="Armenia";
gi.area99930.pubrange="0-4;50-79;800-999";

gi.area99931 = new Object;
gi.area99931.text="Seychelles";
gi.area99931.pubrange="0-4;50-79;800-999";

gi.area99932 = new Object;
gi.area99932.text="Malta";
gi.area99932.pubrange="0-0;10-59;600-699;7-7;80-99";

gi.area99933 = new Object;
gi.area99933.text="Nepal";
gi.area99933.pubrange="0-2;30-59;600-999";

gi.area99934 = new Object;
gi.area99934.text="Dominican Republic";
gi.area99934.pubrange="0-1;20-79;800-999";

gi.area99935 = new Object;
gi.area99935.text="Haiti";
gi.area99935.pubrange="0-2;7-8;30-59;600-699;90-99";

gi.area99936 = new Object;
gi.area99936.text="Bhutan";
gi.area99936.pubrange="0-0;10-59;600-999";

gi.area99937 = new Object;
gi.area99937.text="Macau";
gi.area99937.pubrange="0-1;20-59;600-999";

gi.area99938 = new Object;
gi.area99938.text="Srpska";
gi.area99938.pubrange="0-1;20-59;600-899;90-99";

gi.area99939 = new Object;
gi.area99939.text="Guatemala";
gi.area99939.pubrange="0-5;60-89;900-999";

gi.area99940 = new Object;
gi.area99940.text="Georgia";
gi.area99940.pubrange="0-0;10-69;700-999";

gi.area99941 = new Object;
gi.area99941.text="Armenia";
gi.area99941.pubrange="0-2;30-79;800-999";

gi.area99942 = new Object;
gi.area99942.text="Sudan";
gi.area99942.pubrange="0-4;50-79;800-999";

gi.area99943 = new Object;
gi.area99943.text="Alsbania";
gi.area99943.pubrange="0-2;30-59;600-999";

gi.area99944 = new Object;
gi.area99944.text="Ethiopia";
gi.area99944.pubrange="0-4;50-79;800-999";

gi.area99945 = new Object;
gi.area99945.text="Namibia";
gi.area99945.pubrange="0-5;60-89;900-999";

gi.area99946 = new Object;
gi.area99946.text="Nepal";
gi.area99946.pubrange="0-2;30-59;600-999";

gi.area99947 = new Object;
gi.area99947.text="Tajikistan";
gi.area99947.pubrange="0-2;30-69;700-999";

gi.area99948 = new Object;
gi.area99948.text="Eritrea";
gi.area99948.pubrange="0-4;50-79;800-999";

gi.area99949 = new Object;
gi.area99949.text="Mauritius";
gi.area99949.pubrange="0-1;20-89;900-999";

gi.area99950 = new Object;
gi.area99950.text="Cambodia";
gi.area99950.pubrange="0-4;50-79;800-999";

gi.area99951 = new Object;
gi.area99951.text="Congo - no ranges fixed yet";
gi.area99951.pubrange="";

gi.area99952 = new Object;
gi.area99952.text="Mali";
gi.area99952.pubrange="0-4;50-79;800-999";

gi.area99953 = new Object;
gi.area99953.text="Paraguay";
gi.area99953.pubrange="0-2;30-79;800-999";

gi.area99954 = new Object;
gi.area99954.text="Bolivia";
gi.area99954.pubrange="0-2;30-69;700-999";

gi.area99955 = new Object;
gi.area99955.text="Srpska"
gi.area99955.pubrange="0-1;20-59;600-899;90-99";

gi.area99956 = new Object;
gi.area99956.text="Montenegro"
gi.area99956.pubrange="00-29;300-799;8000-9999";
