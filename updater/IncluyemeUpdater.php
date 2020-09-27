<?php



namespace updater;

class IncluyemeUpdater
{
    protected   $file;
    protected  $plugin;
    protected  $basename;
    protected  $active;
    private  $username;
    private  $repository;
    private  $authorizeToken;
    private  $githubResponse;
    
    public function __construct( $file)
    {
        $this->file = $file;
        add_action('admin_init', [$this, 'set_plugin_properties']);
        
        return $this;
    }
    
    public function setPluginProperties()
    {
        $this->plugin = get_plugin_data($this->file);
        $this->basename = plugin_basename($this->file);
        $this->active = is_plugin_active($this->basename);
    }
    
    public function setUserName( $username)
    {
        $this->username = $username;
    }
    
    /**
     * @param $repository
     */
    public function setRepository( $repository)
    {
        $this->repository = $repository;
    }
    
    /**
     * @param $token
     */
    public function authorize( $token)
    {
        $this->authorizeToken = $token;
    }
    
    public function initialize()
    {
        add_filter('pre_set_site_transient_update_plugins', [$this, 'modifyTransient'], 10, 1);
        add_filter('plugins_api', [$this, 'pluginPopup'], 10, 3);
        add_filter('upgrader_post_install', [$this, 'afterInstall'], 10, 3);
    }
    
    public function modifyTransient( $transient)
    {
        
        if (property_exists($transient, 'checked')) {
            if ($checked = $transient->checked) {
                $this->getRepositoryInfo();
                $out_of_date = version_compare($this->githubResponse['tag_name'], $checked[$this->basename], 'gt');
                if ($out_of_date) {
                    $new_files = $this->githubResponse['zipball_url'];
                    $slug = current(explode('/', $this->basename));
                    $plugin = [
                        'url' => $this->plugin["PluginURI"],
                        'slug' => $slug,
                        'package' => $new_files,
                        'new_version' => $this->githubResponse['tag_name']
                    ];
                    $transient->response[$this->basename] = (object)$plugin;
                }
            }
        }
        
        return $transient;
    }
    
    private function getRepositoryInfo()
    {
        if (is_null($this->githubResponse)) {
            $request_uri = sprintf('https://api.github.com/repos/%s/%s/releases', $this->username, $this->repository);
            if ($this->authorizeToken) {
                $request_uri = add_query_arg('access_token', $this->authorizeToken, $request_uri);
            }
            $response = json_decode(wp_remote_retrieve_body(wp_remote_get($request_uri)), true);
            if (is_($response)) {
                $response = current($response);
            }
            if ($this->authorizeToken) {
                $response['zipball_url'] = add_query_arg(
                    'access_token',
                    $this->authorizeToken,
                    $response['zipball_url']
                );
            }
            $this->githubResponse = $response;
        }
    }
    
    
    public function pluginPopup( $result,  $action,  $args)
    {
        if (!empty($args->slug)) {
            if ($args->slug == current(explode('/', $this->basename))) {
                $this->getRepositoryInfo();
                
                $plugin = [
                    'name' => $this->plugin["Name"],
                    'slug' => $this->basename,
                    'version' => $this->githubResponse['tag_name'],
                    'author' => $this->plugin["AuthorName"],
                    'author_profile' => $this->plugin["AuthorURI"],
                    'last_updated' => $this->githubResponse['published_at'],
                    'homepage' => $this->plugin["PluginURI"],
                    'short_description' => $this->plugin["Description"],
                    'sections' => [
                        'Description' => $this->plugin["Description"],
                        'Updates' => $this->githubResponse['body'],
                    ],
                    'download_link' => $this->githubResponse['zipball_url']
                ];
                
                return (object)$plugin;
            }
        }
        
        return $result;
    }
    
    
    public function afterInstall( $response,  $hook_extra,  $result)
    {
        global $wp_filesystem;
        $install_directory = plugin_dir_path($this->file);
        $wp_filesystem->move($result['destination'], $install_directory);
        $result['destination'] = $install_directory;
        if ($this->active) {
            activate_plugin($this->basename);
        }
        return $result;
    }
}
