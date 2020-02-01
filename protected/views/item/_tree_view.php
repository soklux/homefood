<div class="col-sm-12">
	<div class="row search-page" id="search-page-1">
		<div class="col-xs-12">
			<div class="row">
				<div class="col-xs-12 col-sm-4">
					<!-- #section:pages/search.well -->
					<div class="search-area well well-sm">
						<div class="search-filter-header bg-primary">
							<h5 class="smaller no-margin-bottom">
								<i class="ace-icon fa fa-sliders light-green bigger-130"></i>&nbsp; Refine your Search
							</h5>
						</div>

						<div class="space-10"></div>

						<div class="hr hr-dotted"></div>

						<h4 class="blue smaller">
							<i class="fa fa-tags"></i>
							Category
						</h4>

						<!-- #section:plugins/fuelux.treeview -->
						<div class="tree-container" style="width: 100% !important">
							<ul id="category_tree"></ul>
						</div>

						<!-- /section:plugins/fuelux.treeview -->
						<div class="hr hr-dotted"></div>

						<div class="space-4"></div>
					</div>

					<!-- /section:pages/search.well -->
				</div>

				<div class="col-xs-12 col-sm-8">
					<div class="row">
						<div class="search-area well col-xs-12">
							<div class="pull-left">
								<b class="text-primary">Display</b>

								&nbsp;
								<div id="toggle-result-format" class="btn-group btn-overlap" data-toggle="buttons">
									<label title="Thumbnail view" class="btn btn-lg btn-white btn-success <?=isset(Yii::app()->session['view']) ? (Yii::app()->session['view']=='k' ? 'btn-success active' : '') : ''?>" data-class="btn-success" aria-pressed="true">
										<input type="radio" name="display" onchange="loadProduct('','k')" checked="" autocomplete="off" />
										<i class="icon-only ace-icon fa fa-th"></i>
									</label>

									<label title="List view" class="btn btn-lg btn-white btn-success  <?=isset(Yii::app()->session['view']) ? (Yii::app()->session['view']=='g' ? 'btn-success active' : '') : ''?>" data-class="btn-primary">
										<input type="radio" name="display" onchange="loadProduct('','g')" value="1" autocomplete="off" />
										<i class="icon-only ace-icon fa fa-list"></i>
									</label>
								</div>
							</div>
						</div>
						<div class="space-10"></div>

						<div class="hr hr-dotted"></div>
						<div class="well well-sm">
							
							<div id="result"></div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>
<script src="<?=Yii::app()->theme->baseUrl.'/js/axios.js'?>"></script>
<script type="text/javascript">





</script>

<!-- inline scripts related to this page -->
<script type="text/javascript">
	function loadProduct(category_id,view='k'){
		var url='<?=Yii::app()->createUrl('Item/GetProductByCategory')?>';
		$('#result').html('<div style="text-align:center"><img style="margin:auto !important;" src="<?=Yii::app()->theme->baseUrl?>/images/loading.gif" height="150px"></div>');
		axios.get('GetProductByCategory?category_id='+category_id+'&view='+view).then(res=>{
			$('#result').html(res.data);
		}).catch(function(e){
			console.log(e);
		})
	}
	loadProduct('','<?=isset($_SESSION['view']) ? $_SESSION['view'] : ""?>')
	jQuery(function($){
		var sampleData = initiateDemoData();//see below
		
		$('#category_tree').ace_tree({
			dataSource: sampleData['dataSource2'] ,
			loadingHTML:'<div class="tree-loading"><i class="ace-icon fa fa-refresh fa-spin blue"></i></div>',
			'open-icon' : 'ace-icon fa fa-folder-open',
			'close-icon' : 'ace-icon fa fa-folder',
			'itemSelect' : false,
			'folderSelect': true,
			'multiSelect': false,
			'selected-icon' : null,
			'unselected-icon' : null,
			'folder-open-icon' : 'ace-icon tree-plus',
			'folder-close-icon' : 'ace-icon tree-minus'
		});
		
		
		
		/**
		//Use something like this to reload data	
		$('#category_tree').find("li:not([data-template])").remove();
		$('#category_tree').tree('render');
		*/
		
		
		
		// //please refer to docs for more info
		// $('#category_tree')
		// .on('loaded.fu.tree', function(e) {
		// })
		// .on('updated.fu.tree', function(e, result) {
		// })
		// .on('selected.fu.tree', function(e) {
		// 	console.log(sampleData)
		// })
		// .on('deselected.fu.tree', function(e) {
		// })
		// .on('opened.fu.tree', function(e) {
		// })
		// .on('closed.fu.tree', function(e) {
		// });
		
		
		function initiateDemoData(){
			var dataSource2 = function(options, callback){
				var $data = null
				var category_tree=null
				axios.get('CategoryTree').then(res=>{
					category_tree=res.data;
					if(!("text" in options) && !("type" in options)){
					$data = category_tree;//the root tree
					callback({ data: $data });
					return;
				}
				else if("type" in options && options.type == "folder") {
					if("additionalParameters" in options && "children" in options.additionalParameters)
						$data = options.additionalParameters.children || {};
					else $data = {}//no data
				}
				
				if($data != null)//this setTimeout is only for mimicking some random delay
					setTimeout(function(){callback({ data: $data });} , parseInt(Math.random() * 500) + 200);
					console.log(category_tree);
				}).catch(function(e){
					console.log(e);
				})
				

				//we have used static data here
				//but you can retrieve your data dynamically from a server using ajax call
				//checkout examples/treeview.html and examples/treeview.js for more info
			}
			return {'dataSource2' : dataSource2}
		}

	});
</script>
<style type="text/css">
	.cate-hover:hover{
		text-decoration: underline;
		cursor: pointer;
	}
</style>