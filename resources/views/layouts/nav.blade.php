<div class="masthead">


  <nav class="navbar navbar-toggleable-md navbar-light bg-faded">
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-item nav-link" href="{{@url('propertytype')}}">Home</a>
        <a class="nav-item nav-link" href="{{@url('propertytype/create')}}">Add New</a>
        <a class="nav-item nav-link" href="{{@url('propertytype/')}}">Manage Property Types</a>
          <a class="nav-item nav-link" href="{{route('property_information')}}">Add Property</a>
        
        <?php //echo "url is " . print_r($paramater); ?>
        
        @if (($controller == "PropertyTypeSectionFieldController") && ($action == "create"))
        <a class="nav-item nav-link" href="{{route('propertytype.edit', $propertytype_id->id)}}">Go to Manage Sections</a>
        @endif
        
        
        </a>
        
        <!-- Left Side Of Navbar -->
                   

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a  href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
        
        
      </div>
      
    </div>
  </nav>
</div>
<br/>
