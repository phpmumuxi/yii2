<?php
//1注册脚本
//（1）registerJs() 用于内联脚本。 （2）registerJsFile() 用于注册引入外部脚本文件。
$this->registerJs("var options = ".json_encode($options).";", View::POS_END, 'my-options');
/*第一个参数是我们想插入的实际JS代码。 第二个参数确定了JS代码插入页面的位置。可用的值如下：

    View::POS_HEAD 用在HEAD部分。
    View::POS_BEGIN 用在 <body> 标签的右边。
    View::POS_END 用在 </body> 标签的左边。
    View::POS_READY 为了在 ready 事件中执行代码，这里将自动注册jQuery。
    View::POS_LOAD 为了在 load 事件中执行代码，这里将自动注册jQuery。

最后一个参数是一个唯一的脚本ID，主要是用于标识一段代码块，在添加一段新的代码块时，如果当前页面已经存在同样ID代码块时，那么将会被新的替换。 如果你不传这个参数，JS代码本身将会作为ID来使用。
 2)外部脚本的引入*/
$this->registerJsFile('http://example.com/js/main.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
// 在上面的例子中,我们注册了 main.js 文件，并且依赖于 JqueryAsset 类。 这意味着 main.js 文件将被添加在 jquery.js 的后面。 如果没有这个依赖规范的话，main.js和 jquery.js 两者之间的顺序将不会被定义。

//2注册资源包

\frontend\assets\AppAsset::register($this);

//3.注册 CSS

$this->registerCss("body { background: #f00; }");
/*使用 registerCss() 或者 registerCssFile() 来注册CSS。 前者是注册一段CSS代码块，而后者则是注册引入外部的CSS文件
上面的代码执行结果相当于在页面头部中添加了下面的代码：

<style>
body { background: #f00; }
</style>*/

$this->registerCssFile("http://example.com/css/themes/black-and-white.css", [
    'depends' => [BootstrapAsset::className()],
    'media' => 'print',
], 'css-print-theme');

/*上面的代码将在页面的头部添加一个link引入CSS文件。

    第一个参数指明被注册的CSS文件。
    第二个参数指明 <link> 标签的HTML属性，选项 depends 是专门处理 指明CSS文件依赖于哪个资源包。在这种情况下，依赖资源包就是 yii\bootstrap\BootstrapAsset。这意味着CSS文件将 被添加在 yii\bootstrap\BootstrapAsset 之后。
    最后一个参数指明一个ID来标识这个CSS文件。假如这个参数未传， CSS文件的URL将被作为ID来替代。*/

