<?php

//  URL to PHP contiaining Sql to retreive data
$url = '"http://as400.bass-net.com:8080/php/testjm/aaero/getfolderfiles.php?"';
?>
<!DOCTYPE html>
 <!--Default Settings -->
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<html style="height:100%;">
<head>
    <title>American Aero</title>
</head>
    <meta charset="utf-8">   	
    <link href="../src/src-offline.css" rel="stylesheet">
    <link href="AmericanAero.css" rel="stylesheet">
    <link href="/php/kendoui/styles/kendo.common.min.css" rel="stylesheet">
    <link href="/php/kendoui/styles/kendo.rtl.min.css" rel="stylesheet">
    <link href="/php/kendoui/styles/kendo.default.min.css" rel="stylesheet">
    <link href="/php/kendoui/styles/kendo.dataviz.min.css" rel="stylesheet">
    <link href="/php/kendoui/styles/kendo.dataviz.default.min.css" rel="stylesheet">
    <link href="../src/src.css" rel="stylesheet">
   <script src="../kendoui/js/jquery.min.js"></script>
   <script src="../kendoui/js/kendo.angular.min.js"></script>
   <script src="../kendoui/js/kendo.all.min.js"></script>
   <script src="/php/kendoui/examples/content/shared/js/console.js"></script>
<body>
    
<iframe id="usersign" src="http://as400.bass-net.com:8080/php/horizon/signon/signin.html"></iframe>        

<h1><img src="/php/kendoui/styles/images/american aero.png" style="width:480px;height:70px"></h1>
<a class="k-button" href="http://as400.bass-net.com:8080/profoundui/atrium" style="position: absolute;  top: 26px; right:60px; background-color: green; padding-top:  2px;font-size: medium;">Exit</a>

<h2>Daily Reports</h2>
<div id="example">
      <div id="grid" style="margin: 3px 5px; position: inherit; top: 5px" ></div>
		
	    <script>  $(document).ready(function() {
		     	     
		     
                     findgrid1 = $("#grid").kendoGrid(   {
				dataSource: {
				    transport: {
					read: { url: <?php echo $url?>,
					dataType: "json",
					cache: false },
						schema: { 
						    data: {
							 id: "AADATA" ,
							 fields: {
							     
							        bn: { type: "string" },
							        sn: { tpye: "string" },
							      date: { type: "string" },
						            folder: { type: "string" }
							   
								}
							 }
							}
						}
						
					    },
				scrollable:  true,
				height: 760,
				selectable: "ROW",
				sortable: true,
				filterable: { mode: "row"},
				//groupable: true,
				pageable: {refresh: true,
					    pageSize: 30},
				change: function () {
						    var gview = $("#grid").data("kendoGrid");
						    var selectedItem = gview.dataItem(gview.select());
						    var $batch = selectedItem.bn;
						    var $seq = selectedItem.sq;
						    kendoConsole.log("event :: open" + " " + $batch + " " + $seq);
						    getdoc($batch,$seq);
						    
						    },
				columns: [
						
						
						{ title: "Date", field: "date", width:"5px",
						selectable: "ROW",
						
						filterable: {
						    cell: {
						    operator: "contains",
						    showOperators: false
						    }
						}
						},
						{ title: "Folder Type", field: "folder", width:"40px",
						filterable: {
						    cell: {
						    operator: "contains",
						    showOperators: false
						    }
						}
						}
					      ],
				
			    });
			});

	    function onRefresh(){
				var url = 'http://as400.bass-net.com:8080/php/testjm/aaero/AmericanAero.php?&u='+u;
                                findgrid1.data("kendoGrid").dataSource.transport.options.read.url = url;
				
				}
			       
	    function onOpen(e) {
                    kendoConsole.log("event :: open");
			       }
		
	    function onClick(e) {
                                        
                                        var url = "http://as400.bass-net.com:8080/php/testjm/aaero/AmericanAero.php?";               
                                        findgrid1.data("kendoGrid").dataSource.transport.options.read.url = url;
                                        findgrid1.data("kendoGrid").dataSource.read();
                                        findgrid1.refresh();
                                   
                                }
           
	    function reloadgrid() {
                                    setTimeout(function() {
                                                            var u = document.getElementById('usersign').contentWindow.pui.appJob.user;
                                                            var url = 'http://as400.bass-net.com:8080/php/testjm/aaero/getfolderfiles.php?&u='+u;
                                                            findgrid1.data("kendoGrid").dataSource.transport.options.read.url = url;
                                                            findgrid1.data("kendoGrid").dataSource.read();
                                                                                                                                                        
                                                          }, 1000);
                                   }
		
	    function getdoc(batch,seq) {
                                        try 
                                            {
						var u= document.getElementById('usersign').contentWindow.pui.appJob.user;
						if(u !== null) {
								var url = "http://as400.bass-net.com:8080/php/DMS/anydoc/streamanydoc.php?b="+batch+"&s="+seq+"&u="+u;
								window.open (url, "resizable=yes, left=30, width=1000, height=500");
							       }
					    }
					    
					catch(e) {
                                                 }
				       }
</script>
  
</body></html>
