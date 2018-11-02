<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* Site Language */
function site_language($key=null,$default=null)
{
    return $default;
}


/* Return If Exsist */
function return_if_exists($data,$key=null,$onEmpty=null)
{
    switch (gettype($data))
    {
        case 'array':
            if(!empty($key))
            {
                if(isset($data[$key]))
                {
                    return $data[$key];
                }
                else
                {
                    return (!empty($onEmpty))?$onEmpty:null;
                }
            }
        break;

        case 'object':
            if(!empty($key))
            {
                if(isset($data->{$key}))
                {
                    return $data->{$key};
                }
                else
                {
                    return (!empty($onEmpty))?$onEmpty:null;
                }
            }
        break;
        
        default:
            return (!empty($data))?$data:(!empty($onEmpty))?$onEmpty:null;
        break;
    }
}

/* End of file app_helper.php */
/* Location: ./application/helpers/app_helper.php */