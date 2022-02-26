<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<title>Tree Library</title>
<style>
ul { 
 list-style: none;
} 
.treeview-folder { 
color:black;
font-size:16px;
}
.treeview span:hover { 
 cursor: pointer; 
 font-size:20px;
 color:black; 
} 
.treeview-file { 
 color:black; 
 font-size:14px;
}
.LibraryAnchorTag:-webkit-any-link {color:black;}
.LibraryAnchorTag {color:black;}
.LibraryAnchorTag:visited {color:black;}
.LibraryAnchorTag:hover {cursor: pointer;font-size:24px;color:black;}
.LibraryAnchorTag:active {color:black;}

.LibraryAnchorTagHeader:-webkit-any-link {color:black;}
.LibraryAnchorTagHeader {color:black;}
.LibraryAnchorTagHeader:visited {color:black;}
.LibraryAnchorTagHeader:hover {cursor: pointer;color:black;text-decoration: none;color:red;}
.LibraryAnchorTagHeader:active {color:black;} 

h2 {
	margin-left:1vh;
}

h2 .alt {
  display: none;
}

h2:hover .org {
  display: none;
}

h2:hover .alt {
  display: inline;
}
</style>
<h2>
<span class="org">Tree Library</span>
<span class="alt"><a class='LibraryAnchorTagHeader' href="uploader.php" target="_blank">File Manager</a></span>
</h2>
<div class="Library_Viewer" id="TreeViewDiv">
<?php
class TreeView
{
    private $root;
 
    public function __construct($path)
    {
        $this->root = $path;
    }
 
    public function getTree()
    {
        return $this->createStructure($this->root, true);
    }
 
    private function createStructure($directory, $root)
    {
        $structure = $root ? '<ul class="treeview">' : '<ul>';
 
        $nodes = $this->getNodes($directory);
        foreach ($nodes as $node) {
            $path = $directory.'/'.$node;
            if (is_dir($path) ) {
                $structure .= '<li class="treeview-folder"><b style="font-size: 20px;">- </b>';
                $structure .= '<span>'.$node.'</span>';
                $structure .= self::createStructure($path, false);
                $structure .= '</li>';
            } else {
                $path = str_replace($this->root.'/', null, $path);
                $structure .= '<li class="treeview-file"><b style="font-size: 20px;">- </b>';
				$NODE_TMP=$node;
				$NODE_NOEXTENSION = substr($NODE_TMP, 0, -4);
				$NODE_NOEXTENSION.=" (Click To Open In New Tab)";
                $structure .= '<a class="LibraryAnchorTag" href="Files/'.$path.'" target="_blank">'.$NODE_NOEXTENSION.'</a>';
                $structure .= '</li>';
            }
        }
 
        return $structure.'</ul>';
    }
 
    private function getNodes($directory = null)
    {
        $folders = [];
        $files = [];
 
        $nodes = scandir($directory);
        foreach ($nodes as $node) {
            if (!$this->exclude($node)) {
                if (is_dir($directory.'/'.$node)) {
                    $folders[] = $node;
                } else {
                    $files[] = $node;
                }
            }
        }
 
        return array_merge($folders, $files);
    }
 
    private function exclude($filename)
    {
        return in_array($filename, ['.', '..', 'index.php', '.htaccess', '.DS_Store']);
    }
}
$treeView = new TreeView(__DIR__ . "/Files/");
echo $treeView->getTree();
?>
</div>
<script>
jQuery(document).ready(function($) {
    $('.treeview').find('ul').hide();
 
    $('.treeview-folder span').click(function() {
        $(this).parent().find('ul:first').toggle('medium');
 
        if ($(this).parent().attr('className') == 'treeview-folder') {
            return;
        }
    });
});
</script>
</body>
</html>