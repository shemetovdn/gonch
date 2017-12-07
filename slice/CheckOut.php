<!doctype html>
<html>
<head>
    <title> </title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="css/component.css" />
    <script src="js/modernizr.custom.js"></script>
    <script src="js/classie.js"></script>
    <script src="js/progressButton.js"></script>
    <script src="js/jquery-1.12.0.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
</head>
<body>
<div class="maintemplate">
    <div class="container">
        <!--container -->
        <div class="col-sm-12 checkoutstyle">
            <a href="#" class="logo-mobi visible"><img src="images/logo-mobi.png" alt="" /></a>

            <div class="someicons">
                <a href="#" class="icones"><?=file_get_contents('images/ifo-12.svg')?></a>
                <a href="#" class="lang">Ua</a>
                <a href="#" class="lang">Ru</a>
                <div class="clearfix"></div>
            </div>
            <div class="some-cast-marg"></div>
            <!--content for site -->
            <div class="name-page">Оформление заказа</div>
            <div class="clearfix"></div>
            <div class="somelinecontent"></div>
            <div class="row">
                <div class="col-md-6">
                    <div class="name-title">Контактная данные покупателя:</div>
                    <form>
                        <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Как к Вам обращаться:</label>
                                        <input type="text" class="form-control" placeholder="Ваше имя?">
                                    </div>
                                    <div class="form-group">
                                        <label>Электронная почта:</label>
                                        <input type="email" class="form-control" placeholder="mail@exemple.com">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label></label>
                                        <input type="text" class="form-control" placeholder="Ваша фамилия?">
                                    </div>
                                    <div class="form-group">
                                        <label>Номер Вашего телефона:</label>
                                        <input type="tel" class="form-control" placeholder="+380 ( _ _ ) _ _ _ - _ _ - _ _">
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                        </div>
                        <div class="name-title">Информация для доставки:</div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Выберите способ доставки:</label>
                                    <select class="form-control">
                                        <option>Доставка «Новой почтой»</option>
                                        <option>Доставка «Новой почтой»</option>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="—	—	—	—">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="—	—	—	—">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Месяц">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Год">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Выберите отделение:</label>
                                    <select class="form-control">
                                        <option>Введите населенный пункт</option>
                                        <option>Введите населенный пункт</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Выберите способ оплаты:</label>
                                    <select class="form-control">
                                        <option>Картой на сайте</option>
                                        <option>Картой на сайте</option>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="—	—	—	—">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="—	—	—	—">
                                        </div>
                                    </div>
                                    <div class="col-sm-offset-6 col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="CVC">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label></label>
                                    <select class="form-control">
                                        <option>Выберите номер отделения</option>
                                        <option>Выберите номер отделения</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Ваш комментарий к заказу:</label>
                                    <textarea placeholder="Ваше сообщение" class="form-control">

                                    </textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Выберите способ доставки:</label>
                                    <select class="form-control">
                                        <option>Доставка по адресу</option>
                                        <option>Доставка по адресу</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Адрес получателя:</label>
                                    <select class="form-control">
                                        <option>Введите населенный пункт</option>
                                        <option>Введите населенный пункт</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Выберите способ оплаты:</label>
                                    <select class="form-control">
                                        <option>Наличными при получении</option>
                                        <option>Наличными при получении</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label></label>
                                    <input placeholder="Название улицы" class="form-control" />
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Дом">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder=" ">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Ваш комментарий к заказу:</label>
                                    <textarea placeholder="Ваше сообщение" class="form-control">

                                    </textarea>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <div class="name-title">Ваш заказ:</div>
                    <table id="cart" class="table table-hover table-condensed">
                        <thead>
                        <tr>
                            <th width="50%">Наименование товара:</th>
                            <th width="20%" class=" hidden-xs">Количество:</th>
                            <th width="25%" class=" hidden-xs">К оплате:</th>
                            <th width="5%" class=" hidden-xs"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td data-th="Product">
                                <div class="row">
                                    <div class="col-sm-3 hidden-xs"><img src="images/basket-img.png" alt="" /></div>
                                    <div class="col-sm-9">
                                        <p>Ламінат Classen Visio grande 32/АС4 605x282x8 мм Світлий Бетон 4V-35456</p>
                                    </div>
                                </div>
                            </td>
                            <td data-th="Quantity" class=" text-center">
                                <input type="number" class="form-control text-center" value="1">
                            </td>
                            <td data-th="Subtotal" class=" text-left pricer">82 436 грн</td>
                            <td class=" actions" data-th="">
                                <button class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <table class="totaltable">
                        <tr>
                            <td class="wid-check-1"></td>
                            <td class="wid-check text-center finaltotal">Итого:<span>84 872 грн</span></td>
                        </tr>
                        <tr>
                            <td class="wid-check-1"></td>
                            <td class="wid-check text-center">
                                <a href="#" class="btn btn-success btn-block">В корзину</a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <!--container end-->
    </div>
</div>
<footer>
    <div class="top-footer">
        <div class="container">
            <div class="col-sm-9 col-sm-offset-3">
                <form class="form-inline">
                    <div class="form-group">
                        <label for="staticEmail2">
                            Подписывайтесь<br>
                            на наши новости
                        </label>
                        <input type="text" readonly class="form-control" id="staticEmail2" value="Адрес Вашей почты?">
                    </div>
                    <button type="submit" class="btn btn-primary">Подписаться</button>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="col-sm-9 col-sm-offset-3">
            <div class="row">
                <div class="col-sm-3">
                    <div class="title-ft">Каталог</div>
                    <ul class="footer-links">
                        <li><a href="#">Сантехника</a></li>
                        <li><a href="#">Двери</a></li>
                        <li><a href="#">Напольные покрытия</a></li>
                        <li><a href="#">Электротовары</a></li>
                        <li><a href="#">Инструмент</a></li>
                        <li><a href="#">Строительные материалы</a></li>
                        <li><a href="#">Акции</a></li>
                        <li><a href="#">Скидки</a></li>
                    </ul>
                </div>
                <!-- -->
                <div class="col-sm-3">
                    <div class="title-ft">Gonchar House</div>
                    <ul class="footer-links">
                        <li><a href="#">Компания</a></li>
                        <li><a href="#">Блог</a></li>
                        <li><a href="#">Оферта</a></li>
                        <li><a href="#">Доставка и оплата</a></li>
                        <li><a href="#">Обмен и возврат</a></li>
                    </ul>
                </div>
                <!-- -->
                <div class="col-sm-3">
                    <div class="title-ft">Контакты</div>
                    <ul class="footer-links">
                        <li><a href="#">+380 12 345 67 89</a></li>
                        <li><a href="#">+380 12 345 67 89</a></li>
                        <li><a href="#">+380 12 345 67 89</a></li>
                        <li><a href="#"></a></li>
                        <li><a href="#">mail@gonchar-house.com.ua</a></li>
                    </ul>
                </div>
                <!-- -->
                <div class="col-sm-3">
                    <div class="title-ft">Личный кабинет</div>
                    <ul class="footer-links">
                        <li><a href="#" data-dialog="somedialog-2">Войти / Регистрация</a></li>
                        <li><a href="#">Моя корзина</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="black-line-footer">
        <div class="container">
            <div class="col-sm-9 col-sm-offset-3">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="copy">© 2017 Gonchar House______ Все права защищены </div>
                    </div>
                    <div class="col-sm-6">
                        <span class="proect">Проектирование и дизайн – <a href="#">Glead Head</a>Разработка – <a href="#">Marka</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<div id="somedialog" class="dialog">
    <div class="dialog__overlay"></div>
    <div class="dialog__content">
        <div class="titledialog">Вход</div>
        <div class="closebt"><button class="action" data-dialog-close><?=file_get_contents('images/X.svg')?></button></div>
        <div class="clearfix"></div>
        <div class="sline"></div>
        <div class="noacc">У Вас нет аккаунта?<a href="#" data-dialog="somedialog-2">Зарегестрироваться</a></div>
        <div class="clearfix"></div>
        <form id="form">
            <div class="form-group">
                <input type="email" class="form-control" placeholder="Введите адрес почты">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Введите пароль">
            </div>
            <div class="checkbox pull-left">
                <label>
                    <input type="checkbox"> Запомнить меня
                </label>
            </div>
            <a href="#" class="forgpass">Забыли пароль?</a>
            <div class="clearfix"></div>
            <button type="button" class="btn-cust" data-style="fill" data-horizontal>ОТПРАВИТЬ</button>
        </form>
        <div class="andlogin">Другие способы входа</div>
        <a href="#" class="logface"><img src="images/face-icon.png">Facebook</a>
        <a href="#" class="loggoogle"><img src="images/googleicon.png">Google+</a>
        <div class="clearfix"></div>
    </div>
</div>




<div id="somedialog-2" class="dialog">
    <div class="dialog__overlay"></div>
    <div class="dialog__content">
        <div class="titledialog">Регистрация</div>
        <div class="closebt"><button class="action" data-dialog-close><?=file_get_contents('images/X.svg')?></button></div>
        <div class="clearfix"></div>
        <div class="sline pad"></div>
        <form id="form">
            <div class="form-group">
                <label>Как к Вам обращаться:</label>
                <input type="text" class="form-control" placeholder="Ваше имя?">
            </div>
            <div class="form-group">
                <label>Электронная почта:</label>
                <input type="email" class="form-control" placeholder="mail@exemple.com">
            </div>
            <div class="form-group">
                <label>Номер Вашего телефона:</label>
                <input type="tel" class="form-control" placeholder="+380 ( _ _ ) _ _ _ - _ _ - _ _">
            </div>
            <div class="form-group">
                <label>Придумайте пароль:</label>
                <input type="password" class="form-control" placeholder="Введите пароль">
            </div>
            <div class="form-group">
                <label>Подтвердите пароль:</label>
                <input type="password" class="form-control" placeholder="Введите пароль еще раз">
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox"> Запомнить меня
                </label>
            </div>
            <button type="button" class="btn-cust" data-style="fill" data-horizontal>ОТПРАВИТЬ</button>
        </form>
    </div>
</div>
<script src="js/bootstrap.min.js"></script>
<script src="js/dialogFx.js"></script>
<script>
    (function() {

        var dlgtrigger = document.querySelector( '[data-dialog]' ),
                somedialog = document.getElementById( dlgtrigger.getAttribute( 'data-dialog' ) ),
                dlg = new DialogFx( somedialog );

        dlgtrigger.addEventListener( 'click', dlg.toggle.bind(dlg) );

    })();
</script>

<script src="js/scripts.js"></script>

</body>
</html>