@extends("layout.header")
@section("content")
	<!-- start: Content -->
	<div id="content" class="span10">


	<ul class="breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="index.html">Home</a>
			<i class="icon-angle-right"></i>
		</li>
		<li><a href="#">Tables</a></li>
	</ul>

	<div class="row-fluid sortable">
		<div class="box span12">
			<div class="box-header">
				<h2><i class="halflings-icon white align-justify"></i><span class="break"></span>{{$title}}</h2>
				<div class="box-icon">
					<a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a>
					<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
					<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
				</div>
			</div>
			<div class="box-content">
				<table class="table table-bordered table-striped table-condensed">
					  <thead>
						  <tr>
							  <th>物品名称</th>
							  <th>防护部位</th>
							  <th>物品等级</th>
                              <th>可用职业</th>
                              <th>物品出处</th>
							  <th>操作</th>
						  </tr>
					  </thead>
					  <tbody>
						  @foreach($list as $ls)
						<tr>

							<td class="center">{{$ls->name}}</td>
                            <td class="center">{{$ls->parts}}</td>
							<td class="center">{{$ls->grade}}</td>
                            <td class="center">{{$ls->profession}}</td>
                            <td class="center">{{$ls->origin_fuben}}</td>
							<td class="center">
								<a class="btn btn-success" href="#">
									<i class="halflings-icon white zoom-in"></i>
								</a>
								<a class="btn btn-info" href="#">
									<i class="halflings-icon white edit"></i>
								</a>
								<a class="btn btn-danger" href="#">
									<i class="halflings-icon white trash"></i>
								</a>
							</td>
						</tr>
						@endforeach

					  </tbody>
				 </table>
				 <div class="pagination pagination-centered">
					 {{$list->links()}}
				</div>
			</div>
		</div><!--/span-->
	</div><!--/row-->
	</div><!--/.fluid-container-->

	<!-- end: Content -->
	</div><!--/#content.span10-->
	</div><!--/fluid-row-->
@endsection
