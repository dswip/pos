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

/* Data Table Query */
function datatable_query($model,$query)
{
    $search = (isset($query['search']['value']))?$query['search']['value']:FALSE;
    $_model = $model;

    if(isset($query['only_trash']) && filter_var($query['only_trash'],FILTER_VALIDATE_BOOLEAN))
    {
        try 
        {
            $_model = $_model->onlyTrashed();
        }
        catch (Exception $e)
        {

        }
    }
    elseif(isset($query['with_trash']) && filter_var($query['with_trash'],FILTER_VALIDATE_BOOLEAN))
    {
        try 
        {
            $_model = $_model->withTrashed();
        }
        catch (Exception $e)
        {
            
        }
    }

    if(!empty($search))
    {
        foreach (show_columns($model->getTable()) as $column_key => $column)
        {
            if($column_key == 0)
            {
                $_model = $_model->where($column,'LIKE','%'.$search.'%');
            }
            else
            {
                $_model = $_model->orWhere($column,'LIKE','%'.$search.'%');
            }
        }
    }

    if(isset($query['columns']) && is_array($query['columns']))
    {
        foreach ($query['columns'] as $key => $column)
        {
            if(isset($query['columns'][$key]['search']['value']) && !empty($query['columns'][$key]['search']['value']))
            {
                $search_column = $query['columns'][$key]['data'];
                $search_value  = $query['columns'][$key]['search']['value'];
                if(in_array($search_column, show_columns($model->getTable())))
                {
                    $_model = $_model->where($search_column,'LIKE','%'.$search_value.'%');
                }
            }
        }
    }
    
    if(!empty($query['order']))
    {
        if(isset($query['columns']))
        {
            $column = $query['columns'][$query['order'][0]['column']]['data'];
        }
        else
        {
            if(isset($query['order']['column']))
            {
                $column = $query['order']['column'];
            }
            else
            {
                $column = $model->getKeyName();
            }
        }

        if(isset($query['order'][0]['dir']))
        {
            $type = $query['order'][0]['dir'];
        }
        else
        {
            if(isset($query['order']['type']))
            {
                $type = $query['order']['type'];    
            }
            else
            {
                $type = 'asc';
            }
        }

        if(in_array($column, show_columns($model->getTable())))
        {
            $_model = $_model->orderBy($column,$type);
        }
    }
    return $_model;
}

/* End of file app_helper.php */
/* Location: ./application/helpers/app_helper.php */