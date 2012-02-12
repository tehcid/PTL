<?php
    error_reporting(E_ALL);

    define('IN_PTL', true);

    // load user config file
    require('config.php');

    // does the templates folder actually exist?
    if(!is_dir($config['folder_templates']))
        die("Templates folder \"{$config['folder_templates']}\" doesn't exist. Make sure \$config['folder_templates'] is set correctly.");

    // see if we can access the templates folder
    if(!chdir($config['folder_templates']))
        die("Insufficient access to templates folders \"{$config['folder_templates']}\".");

    // grab template contents
    $template = @file_get_contents($config['site_template']);

    if($template)
    {
        // validate template file
        if(!strpos($template, '%CONTENT%'))
            die('%CONTENT% not found in template.');

        // retrieve the page var if it's there
        $page = array_key_exists('page', $_GET) ? $page = $page = htmlspecialchars($_GET['page']) : $page = "";

        // traverse through template directory and match with page var
        if($dh = opendir('.'))
        {
            $found = false;

            // attempt to load a specified page
            if($page)
            {
                while(($file = readdir($dh)) !== false)
                {
                    // traverse through candidate templates
                    if(substr($file, 0, 4) == "cnt_")
                    {
                        $parts = explode(".", substr($file, 4));

                        if(end($parts) != "html")
                            continue;

                        if($parts[0] == $page)
                        {
                            $content = @file_get_contents($file);
                            $found = true;
                            break;
                        }
                    }
                }

                closedir($dh);
            }

            if(!$found)
            {
                $content = @file_get_contents($config['default_content']);

                if(!$content)
                    die("Default content file \"{$config['default_content']}\" not found.");
            }
        }

        $template = str_replace('%CONTENT%', $content, $template);
        $template = str_replace('%IMGDIR%', $config['folder_images'], $template);
        $template = str_replace('%CSSDIR%', $config['folder_css'], $template);

        print $template;
    }

    else
    {
        die('Template base not found.');
    }
?>