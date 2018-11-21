<!doctype html>
<html>
<?php
    $root = $_SERVER['SERVER_NAME'];
    $assets = 'http://' . $root . '/.assets/';
?>
<head>
   <meta charset="UTF-8">
   <title>Matt Cromwell Presentation Slides | 2018</title>

    <link rel="shortcut icon" href="http://<?php echo $root; ?>/.favicon.ico">
    <link rel="stylesheet" href="http://<?php echo $root; ?>/.assets/.style.css">
    <link rel="stylesheet"
          href="http://<?php echo $root; ?>/.assets/socialicons.css">

    <script src="http://<?php echo $root; ?>/.assets/.sorttable.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/SocialIcons/1.0.1/soc.min.js"></script>
</head>

<body>
<div id="container">
    <h1>Matt Cromwell Presentation Slides</h1>
    <div class="soc">
        <p><small>My Social Profiles:</small></p>
        <a href="https://facebook.com/mathetos" class="soc-facebook" title="Facebook" rel="noopener" target="_blank"></a>
        <a href="https://twitter.com/learnwithmattc" class="soc-twitter" title="Twitter" rel="noopener" target="_blank"></a>
        <a href="https://www.mattcromwell.com" class="soc-wordpress" title="Website" rel="noopener" target="_blank"></a>
        <a href="https://github.com/mathetos" class="soc-github" title="Github" rel="noopener" target="_blank"></a>
    </div>

	<table class="sortable">
	    <thead>
		<tr>
			<th>Presentation</th>
			<th>Publish Date</th>
		</tr>
	    </thead>
	    <tbody><?php
		
	function getTitle($url) {
		$data = file_get_contents($url);
		$title = preg_match('/<title[^>]*>(.*?)<\/title>/ims', $data, $matches) ? $matches[1] : null;
		
		return $title;
	}

	// Adds pretty filesizes
	function pretty_filesize($file) {
		$size=filesize($file);
		if($size<1024){$size=$size." Bytes";}
		elseif(($size<1048576)&&($size>1023)){$size=round($size/1024, 1)." KB";}
		elseif(($size<1073741824)&&($size>1048575)){$size=round($size/1048576, 1)." MB";}
		else{$size=round($size/1073741824, 1)." GB";}
		return $size;
	}
	
	function make_links($text = '') {
		// The Regular Expression filter
		$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";

		// Check if there is a url in the text
		if(preg_match($reg_exUrl, $text, $url)) {

			   // make the urls hyper links
			   return preg_replace($reg_exUrl, '<a href="' . $url[0] . '" class="external" rel="noopener" target="_blank">' . $url[0] . '</a> ', $text);

		} else {

			   // if no urls in the text just return the text
			   return $text;

		}
	}
	
	function get_root_dirs() {

		$rootdir = $_SERVER['DOCUMENT_ROOT'] . '/';
		$rooturl = $_SERVER['SERVER_NAME'];
		
		//get all files in specified directory
		$files = glob($rootdir . "*");
		
		echo '<div class="navigation">';
		echo '<p class="years"> Navigation: ';
		echo '<a href="http://' . $rooturl . '">HOME</a>';
		
		//print each file name
		foreach($files as $file) {
			
			$dirname = trim($file, '/home/mattcrom/public_html/slides/');
			$dirurl = $rooturl . '/' . $dirname; 
			//check to see if the file is a folder/directory
			if(is_dir($file)) {
				echo '<a href="http://' . $dirurl . '">' . $dirname . '</a>';
			}
		}
		
		echo '</p></div>';
	}
	
	get_root_dirs();

 	// Checks to see if veiwing hidden files is enabled
	if($_SERVER['QUERY_STRING']=="hidden")
	{$hide="";
	 $ahref="./";
	 $atext="Hide";}
	else
	{$hide=".";
	 $ahref="./?hidden";
	 $atext="Show";}

	 // Opens directory
	 $myDirectory=opendir(".");

	// Gets each entry
	while($entryName=readdir($myDirectory)) {
	   $dirArray[]=$entryName;
	}

	// Closes directory
	closedir($myDirectory);

	// Counts elements in array
	$indexCount=count($dirArray);

	// Sorts files
	rsort($dirArray);

	// Loops through the array of files
	for($index=0; $index < $indexCount; $index++) {

	// Decides if hidden files should be displayed, based on query above.
	    if(substr("$dirArray[$index]", 0, 1)!=$hide) {

	// Resets Variables
		$favicon="";
		$class="file";

	// Gets File Names
		$name=$dirArray[$index];
		$namehref=$dirArray[$index];


	// Separates directories, and performs operations on those directories
		if(is_dir($dirArray[$index])) {
				$extn="&lt;Directory&gt;";
				$size="&lt;Directory&gt;";
				$sizekey="0";
				$class="dir";

            // Gets favicon.ico, and displays it, only if it exists.
            if(file_exists("$namehref/favicon.ico")) {
                    $favicon=" style='background-image:url($namehref/favicon.ico);'";
                    $extn="&lt;Website&gt;";
            }

            // Cleans up . and .. directories
            if($name=="."){$name=". (Current Directory)"; $extn="&lt;System Dir&gt;"; $favicon=" style='background-image:url($namehref/.favicon.ico);'";}
            if($name==".."){$name=".. (Parent Directory)"; $extn="&lt;System Dir&gt;";}

            $tags = get_meta_tags($namehref . '/index.html');
            $curr_dir = trim(dirname(__FILE__), '/app/public/');
            $date = ( !empty($tags['date']) ? date('F j, Y', strtotime($tags['date'])) : $curr_dir );
            $timestamp = ( !empty($tags['date']) ? date('Ymd', strtotime($tags['date'])) : $curr_dir );
		}

        // Output
        echo("
            <tr class='$class'>
                <td class=\"title\"><a href='./$namehref'$favicon class='name'>" . getTitle($namehref . '/index.html') . "</a><p class=\"description\">
                " . make_links($tags['description']) . "</p></td>
                <td sorttable_customkey='" . $timestamp . "' id='pub_date'><a href='./$namehref'>" . $date . "</a></td>
            </tr>");
        }
	}
	?>
	    </tbody>
	</table>
</div>
</body>
</html>
