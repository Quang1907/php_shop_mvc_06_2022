<h1>DANH SACH TIN TUC</h1>
{{ $new_title }}<br>
{{ $new_content }}<br>
{{'unicode'}}<br>
{! $new_author !}
{{ toSlug('Tieu de bai viet') }}
<!-- {! $new_title !} -->
{{ !empty($page_title) ? $page_title : "khong co title" }}
{{ md5('quangcntt') }}

@if (!empty($new_author))
<p> Ten tac gia : $new_author </p>
@else
<p>khong co author</p>
@endif

@if(md5(12345) == '')
<h4>MD5: {{md5(12345)}}</h4>
@elseif($new_author == 'quang')
<h4>{{$new_author}}</h4>
@endif


@php
$number = 1345;
echo $number;

$data = [
'item 1',
'item 13',
'item 2',
'item 243',
];
@endphp

{{$number}}

@for($i=0; $i < count($data); $i++) 
<p>{{$data[$i]}}</p>
@endfor

@php
$i = 10;
@endphp
@while($i > 0)
<p>{{$i}}</p>
@php
$i--
@endphp
@endwhile

@php
$data1 = [
'item 1',
'item 13',
'item 2',
'item 243',
];
@endphp

@foreach($data1 as $data)
    {{$data}}
@endforeach