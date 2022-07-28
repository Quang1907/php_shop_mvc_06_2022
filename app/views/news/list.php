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
