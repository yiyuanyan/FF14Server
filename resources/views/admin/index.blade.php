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
							  <th>副本名称</th>
							  <th>副本地点</th>
							  <th>限制级别</th>
							  <th>限制时间</th>
							  <th>限制人数</th>
							  <th>操作</th>
						  </tr>
					  </thead>
					  <tbody>
						  @foreach($list as $ls)
						<tr>
							<td>{{$ls->name}}</td>
							<td class="center">{{$ls->place}}</td>
							<td class="center">{{$ls->start_level}}</td>
							<td class="center">{{$ls->time_limit}}</td>
							<td class="center">{{$ls->user_number}}</td>
							<td class="center">
								<span class="label label-success">Active</span>
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
