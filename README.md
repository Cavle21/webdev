# webdev
image gallery backend



Four classes. 

Picture.class.php is responsible for holding relevant data and saving meta data to the database and the actual file
to the server.

The exception class is designed to catch any errors associated with the $_FILES['image']['errors'] array. And return them.

Gallery.class.php displays the pictures.

pagination class will take care of paging the gallery when pictures in gallery are larger than the page.

no live option yet. Will be implementing in the near future.



