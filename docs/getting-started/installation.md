# Installation

* **clone project source code**
get clone https://github.com/soklux/homefood.git

* **download Yii1 framwork latest here**
[Source Code (.zip](https://www.yiiframework.com/download#yii1) 
Unpack the Yii Framework Folder to a Web-accessible directory


* **create db with SQL file you own saperately**
not posting here

![Project Directory Example](https://ikngqa.by.files.1drv.com/y4mjo6F9vjvN3KVTBoFtZgomUrKHasuWVlDi2LUUX6nsIrsqP1iK84BhNhFr14XahJLw9_4WSgRxbZkVaOuF6-QxHykNGjRBsO19C-OjQmji2dOJE56lsmZEur2-txRjunJSS2qs4kfn4PMpQ0vXqok37FYn6gHJVbjf3GT8hazA8ZuH14xwG7pX7kKfT_ZCa4CQLohSqP5G2SFZ5STOYZouw?width=878&height=518&cropmode=none)


# [Directory Structure](getting-started/directory-structure.md)

Yii assumes a default set of directories used for various purposes. Each of them can be customized if needed.

 * WebRoot/protected: this is the application base directory holding all security-sensitive PHP scripts and data files. Yii has a default alias named application associated with this path. This directory and everything under should be protected from being accessed by Web users. It can be customized via CWebApplication::basePath.

 * WebRoot/protected/runtime: this directory holds private temporary files generated during runtime of the application. This directory must be writable by Web server process. It can be customized via CApplication::runtimePath.

 * WebRoot/protected/extensions: this directory holds all third-party extensions. It can be customized via CApplication::extensionPath. Yii has a default alias named ext associated with this path.

 * WebRoot/protected/modules: this directory holds all application modules, each rep- resented as a subdirectory.

 * WebRoot/protected/controllers: this directory holds all controller class files. It can be customized via CWebApplication::controllerPath.

 * WebRoot/protected/views: this directory holds all view files, including controller views, layout views and system views. It can be customized via CWebApplica- tion::viewPath.

 * WebRoot/protected/views/ControllerID: this directory holds view files for a single controller class. Here ControllerID stands for the ID of the controller. It can be customized via CController::viewPath.
 
 *  WebRoot/protected/views/layouts: this directory holds all layout view files. It can be customized via CWebApplication::layoutPath.

 * WebRoot/protected/views/system: this directory holds all system view files. System views are templates used in displaying exceptions and errors. It can be customized via CWebApplication::systemViewPath.

 * WebRoot/assets: this directory holds published asset files. An asset file is a private file that may be published to become accessible to Web users. This directory must be writable by Web server process. It can be customized via CAssetManager::basePath.

 * WebRoot/themes: this directory holds various themes that can be applied to the appli- cation. Each subdirectory represents a single theme whose name is the subdirectory name. It can be customized via CThemeManager::basePath.
