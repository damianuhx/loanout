@extends('frame')

@section('content')

    <?php
    $t=config('app.translations');

    foreach ($t as $key=>$value)
    {
        $t[$key]=$value[$language];
    }
    ?>

    <div id="browser">

        <div id="kategorien" class="panel pleft">
            <h2>{{ucfirst($t['categories'])}}</h2>
            <ul>
                @foreach ($categories as $entry)
                    <li>
                        <a href="{{env('HREF_MAIN').'types/'.$entry['id']}}"
                        @if (isset($category) && $category['id']==$entry['id'])
                           class="current"
                                @endif
                                >{{$entry['name_'.$language]}}</a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div id="modelle" class="panel pcenter">
            <h2>{{ucfirst($t['models'])}}</h2>
            <ul>
                @foreach ($types as $entry)
                    <li><div class="status
                    @if ($entry['color']==2)
                    green
                    @elseif($entry['color']==1)
                    orange
                    @else
                                red
                                @endif
                                "></div>
                        <a href="{{env('HREF_MAIN').'objects/'.$entry['id']}}"
                        @if (isset($type) && $type['id']==$entry['id'])
                           class="current"
                                @endif
                        >{{$entry['name']}}</a>
                    </li>
                @endforeach
            </ul>
        </div>



        <div id="sn" class="panel pright">
            <h2>{{ucfirst($t['objects'])}}</h2>
            <ul>
                @foreach ($objects as $entry)
                    <li><div class="status
                    <?php $row=$entry['name']; ?>
                    @if ($entry['color']==2)
                    green
                    @elseif($entry['color']==1)
                    orange
                    @else
                    red
                    <?php $row=$entry['name'].' ('.$entry['return_date'].')'; ?>
                    @endif
                    "></div> {!! HTML::link( env('HREF_MAIN').'details/'.$entry['id'], $row, array('data-fancybox-type' => 'iframe', 'class' => 'fancybox')) !!}</li>
                @endforeach
            </ul>
        </div>






        <div class="clear"></div>


    </div>

@stop




