<!DOCTYPE html>
<html>
<head>
	<title>Testing</title>
</head>
<body>

<table class="datatable_server_side">
	
</table>

</body>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.29.0/sweetalert2.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.29.0/sweetalert2.all.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/jszip-2.5.0/dt-1.10.18/af-2.3.2/b-1.5.4/b-colvis-1.5.4/b-flash-1.5.4/b-html5-1.5.4/b-print-1.5.4/cr-1.5.0/fc-3.2.5/fh-3.1.4/kt-2.5.0/r-2.2.2/rg-1.1.0/rr-1.2.4/sc-1.5.0/sl-1.2.6/datatables.min.css"/>
 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/jszip-2.5.0/dt-1.10.18/af-2.3.2/b-1.5.4/b-colvis-1.5.4/b-flash-1.5.4/b-html5-1.5.4/b-print-1.5.4/cr-1.5.0/fc-3.2.5/fh-3.1.4/kt-2.5.0/r-2.2.2/rg-1.1.0/rr-1.2.4/sc-1.5.0/sl-1.2.6/datatables.min.js"></script>

<script type="text/javascript">
var dt_export_options = function()
{
	var return_config = 
	{
		exportOptions:
		{
			modifier:
			{
				selected:true,
			},
			columns: ':visible',
		}
    }
    return return_config;
}

var datatable_buttons 	= 
[
	$.extend(true,{}, dt_export_options,{
		extend: 'print',
		text:'print <i class="fa fa-print"></i>',
		exportOptions:
		{
			columns: ':visible'
		}
	}),
	$.extend(true,{}, dt_export_options,{
		extend: 'copy',
		text:'copy <i class="fa fa-copy"></i>',
		exportOptions:
		{
			columns: ':visible'
		}
	}),
	$.extend(true,{}, dt_export_options,{
		extend: 'pdfHtml5',
		text:'pdf <i class="fa fa-file-pdf-o"></i>',
		exportOptions:
		{
			columns: ':visible'
		},
		action:function(e, dt, node, config)
		{
			dt_export_custom_filename(this,e, dt, node, config,'pdfHtml5');
		}
	}),
	$.extend(true,{}, dt_export_options,{
		extend: 'excelHtml5',
		text:'excel <i class="fa fa-file-excel-o"></i>',
		exportOptions:
		{
			columns: ':visible'
		},
		action:function(e, dt, node, config)
		{
			dt_export_custom_filename(this,e, dt, node, config,'excelHtml5');
		}
	}),
	$.extend(true,{}, dt_export_options,{
		extend: 'csv',
		text:'csv',
		exportOptions:
		{
			columns: ':visible'
		},
		action:function(e, dt, node, config)
		{
			dt_export_custom_filename(this,e, dt, node, config,'csv');
		}
	}),
	{
		extend:'colvis',
		text:'column <i class="fa fa-columns"></i>'
	}
]

function dt_export_custom_filename(that,e,dt,node,config,extend)
{
	if(extend)
	{
		swal({
			title: 'Export File Name',
			input: 'text',
			inputPlaceholder:'enter file name',
			showCancelButton: true,
			confirmButtonText: 'Submit',
			showLoaderOnConfirm: true,
		}).then(function(result){
			if(result)
			{
				config.filename = result
				$.fn.DataTable.ext.buttons[extend].action.call(that, e, dt, node, config)
			}
		},function(dismiss){})
	}
}
$('.datatable_server_side').DataTable({
	dom:
		"<'row'<'col-sm-4 dt_length'l><'col-sm-4'><'col-sm-4'f>>"+
		"<'row '<'col-sm-12'tr>>"+
		"<'row dt_btn '<'col-sm-4 col-md-4 col-lg-4'i><'col-sm-6 col-md-6 col-lg-6 pull-right'B>>"+
		"<'row '<'col-sm-12 col-lg-12 pull-right'p>>",
	buttons:datatable_buttons,
	processing:true,
    serverSide:true,
    ajax:
    {
    	url:'<?php echo base_url('kecamatan/list');?>',
    	data:
    	{
    		ajax:true
    	},
    	dataFilter:function(data)
		{
			var json = jQuery.parseJSON(data);
			json.recordsTotal		= json.record_total;
			json.recordsFiltered	= json.record_filtered;
			return JSON.stringify(json);
		}
    },
    columnDefs:
    [
        {
        	title:"#",
            targets: [0],
            defaultContent:null,
            searchable: false,
            orderable: false
        },
		{
			data:'id',
			targets:1,
			title:'no',
			render:function (data, type, full, meta)
			{
				return meta.row + meta.settings._iDisplayStart + 1;
			}
		},
        {
        	title:"id kabupaten",targets:2
        },
        {
        	title:"nama kabupaten",targets:3
        }
    ],
    columns:
    [
    	{
            data:'id',
            render:function (data, type, full, meta)
            {
                return '<input type="checkbox" class="bulk_option flat-green" name="bulk_check[]" value="'+data+'"> ';
            }
        },
        {data:null},
        {data:'id_kabupaten'},
        {data:'nama'}
    ],
    drawCallback:function(settings)
	{
		var api = this.api();
		$(this).on('column-visibility.dt', function(e,settings,column,state){
			// App.iCheckInit('flat_green').on('ifChecked', function(event){
			// 	api.row($(this).parents('tr')).select()}).on('ifUnchecked',function(){
			// 	api.row($(this).parents('tr')).deselect()
			// })
		});

			// App.iCheckInit('flat_green').on('ifChecked', function(event){
			// 	api.row($(this).parents('tr')).select()}).on('ifUnchecked',function(){api.row($(this).parents('tr')).deselect()
			// })
	}
})
</script>
</html>