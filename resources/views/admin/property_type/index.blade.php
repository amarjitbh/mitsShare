@extends ('layouts.admin_layout')
@section('css')
<link rel="stylesheet" href="{{ URL::asset('admin/css/custom.css') }}"/>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Manage Property Types<a class="btn btn-primary pull-right btn-sm" href="{{route('propertytype.create')}}">
                                Add Property Type
                            </a></h4>
                        <p class="category">Manage all Property Types</p>

                    </div>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="content table-responsive table-full-width">
                        <table class="table table-hover table-striped">
                            <thead>
                            <th>Sr. No.</th>
                            {{--<th>Id</th>--}}
                            <th>Name</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                            <th class="text-right">Actions</th>
                            </thead>
                            <tbody>
                            <?php //$i=0;

                            $i = $PropertyTypes->perPage() * ($PropertyTypes->currentPage()-1);

                            ?>
                            @foreach ($PropertyTypes as $PropertyType)
                                <tr>
                                    <td>{{++$i}}</td>
                                    {{-- <td>{{$PropertyType->id}}</td> --}}
                                    <td>{{$PropertyType->name}}</td>
                                    <td>{{$PropertyType->created_at->format('d-M-Y')}}</td>
                                    <td>{{$PropertyType->updated_at->format('d-M-Y')}}</td>
                                    <td class="text-right table-action-btns">
                                        {{-- {{@url('app').'/'.$PropertyType->id}} --}}
                                        <div class="action-btn">
                                            <a href="{{@url('propertytype').'/'.$PropertyType->id.'/edit'}}" class="btn btn-primary btn-sm">Manage Section</a>
                                        </div>
                                        <div class="action-btn">
                                            <form class="d-inline-block" action="{{@url('propertytype').'/'.$PropertyType->id}}" method="post">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            @if(!count($PropertyTypes))
                                <tr>
                                    <td align="center" colspan="5">Data not found</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <div class="pagination-section">
                        <?php echo $PropertyTypes->links(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection