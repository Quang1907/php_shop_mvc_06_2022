echo $title
echo toSlug('quangcntt')

{{$title}} => <?php echo htmlentities($title); ?>
{!$title!} => <?php echo $title; ?>
{!toSlug('quangcntt')!} => <?php echo toSlug('quangcntt'); ?>
