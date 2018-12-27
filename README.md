# MSF-screenshot-album

## 说明
msf的meterpreter中截屏时，默认截屏图片保存的路径是当前工作目录。在外网服务器上使用msf时如果要查看截屏就不太方便。所以我就写了这个工具，可以在web中访问msf的截屏

## 使用
在服务器上安装Apache和PHP，修改代码中的$pass为你的msf截屏文件的路径，在getPass()函数中修改你的密码，然后直接访问index.php?p=你的密码。

注意Apache用户是否有权限进入截屏文件目录，是否有权限读取截屏文件。

截屏按照先后顺序来排序的，默认只展示最新的2张截屏，小图压缩了图片质量，500kb的图片压缩后只有50kb左右。点击小图可以查看原图。为了节约带宽(考虑到国内大部分vps都是1兆带宽卡的批爆)，从第3张开始显示为统一的默认图片，浏览器会调缓存，就不会一直从服务器上加载。。点一下默认图片才加载小图，再点小图可以查看原图。
<<<<<<< HEAD

=======
>>>>>>> 4be0fd41b9fc655805c5b9ee3a66ddf34a8cdb75
