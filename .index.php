<!doctype html>
<html>
<?php $root = $_SERVER['SERVER_NAME']; ?>
<head>
    <meta charset="UTF-8">
    <title>Matt Cromwell Presentation Slides</title>

    <link rel="shortcut icon" href="http://<?php echo $root; ?>/.favicon.ico">
    <link rel="stylesheet"
          href="http://<?php echo $root; ?>/.assets/.style.css">
	<link rel="stylesheet"
          href="http://<?php echo $root; ?>/.assets/socialicons.css">
	
	<script src="http://<?php echo $root; ?>/.assets/.sorttable.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/SocialIcons/1.0.1/soc.min.js"></script>
</head>

<body>
<div id="container">
    <h1>Matt Cromwell Presentation Slides</h1>
    <div class="description">
		<p>This is where all my slides are hosted. They are sorted by year and then by their presentation name. 
		I try to always indicate which WordCamp/Conference it was presented at either in the description or title.
    	<p>
    </div>
    
	<div class="directories">
		<?php

		// Checks to see if veiwing hidden files is enabled
		if ( $_SERVER['QUERY_STRING'] == "hidden" ) {
			$hide  = "";
			$ahref = "./";
			$atext = "Hide";
		} else {
			$hide  = ".";
			$ahref = "./?hidden";
			$atext = "Show";
		}

		// Opens directory
		$myDirectory = opendir( "." );

		// Gets each entry
		while ( $entryName = readdir( $myDirectory ) ) {
			$dirArray[] = $entryName;
		}

		// Closes directory
		closedir( $myDirectory );

		// Counts elements in array
		$indexCount = count( $dirArray );

		// Sorts files
		rsort( $dirArray );

		// Loops through the array of files
		for ( $index = 0; $index < $indexCount; $index ++ ) {

			// Decides if hidden files should be displayed, based on query above.
			if ( substr( "$dirArray[$index]", 0, 1 ) != $hide ) {

				// Resets Variables
				$favicon = "";
				$class   = "file";

				// Gets File Names
				$name     = $dirArray[ $index ];
				$namehref = $dirArray[ $index ];

				// Gets Date Modified
				$modtime = date( "M j Y g:i A", filemtime( $dirArray[ $index ] ) );
				$timekey = date( "YmdHis", filemtime( $dirArray[ $index ] ) );


				// Separates directories, and performs operations on those directories
				if ( is_dir( $dirArray[ $index ] ) ) {
					$extn    = "&lt;Directory&gt;";
					$size    = "&lt;Directory&gt;";
					$sizekey = "0";
					$class   = "dir";

					// Gets favicon.ico, and displays it, only if it exists.
					if ( file_exists( "$namehref/favicon.ico" ) ) {
						$favicon = " style='background-image:url($namehref/favicon.ico);'";
						$extn    = "&lt;Website&gt;";
					}

					// Cleans up . and .. directories
					if ( $name == "." ) {
						$name    = ". (Current Directory)";
						$extn    = "&lt;System Dir&gt;";
						$favicon = " style='background-image:url($namehref/.favicon.ico);'";
					}
					if ( $name == ".." ) {
						$name = ".. (Parent Directory)";
						$extn = "&lt;System Dir&gt;";
					}
				} // File-only operations

				// Output
				echo( "

				<a href='./$namehref'$favicon class='dir'>$name</a>" );
			}
		}
	?>
	</div>
	<div class="soc">
		<p><small>My Social Profiles:</small></p>
		<a href="https://facebook.com/mathetos" class="soc-facebook" title="Facebook" rel="noopener" target="_blank"></a>
		<a href="https://twitter.com/learnwithmattc" class="soc-twitter" title="Twitter" rel="noopener" target="_blank"></a>
		<a href="https://www.mattcromwell.com" class="soc-wordpress" title="Website" rel="noopener" target="_blank"></a>
		<a href="https://github.com/mathetos" class="soc-github" title="Github" rel="noopener" target="_blank"></a>
	</div>
</div>
</body>
</html>
