<?php

Route::redirect('/admin', '/'.app()->getLocale().'/admin');

// Joystick Administration
Route::group(['prefix' => '{lang}/admin', 'middleware' => ['auth', 'role:admin']], function () {

    Route::get('/', 'Joystick\AdminController@index');
    Route::get('filemanager', 'Joystick\AdminController@filemanager');
    Route::get('frame-filemanager', 'Joystick\AdminController@frameFilemanager');

    Route::resources([
        'categories' => 'Joystick\CategoryController',
        'companies' => 'Joystick\CompanyController',
        'products' => 'Joystick\ProductController',
        'regions' => 'Joystick\RegionController',
        'articles' => 'Joystick\ArticleController',
        'languages' => 'Joystick\LanguageController',
        'modes' => 'Joystick\ModeController',
        'options' => 'Joystick\OptionController',
        'orders' => 'Joystick\OrderController',
        'pages' => 'Joystick\PageController',
        'section' => 'Joystick\SectionController',
        'slide' => 'Joystick\SlideController',
        'roles' => 'Joystick\RoleController',
        'users' => 'Joystick\UserController',
        'permissions' => 'Joystick\PermissionController'
    ]);

    Route::get('categories-actions', 'Joystick\CategoryController@actionCategories');
    Route::get('companies-actions', 'Joystick\CompanyController@actionCompanies');

    Route::get('products-actions', 'Joystick\ProductController@actionProducts');
    Route::get('products-search', 'Joystick\ProductController@search');
    Route::get('products-category/{id}', 'Joystick\ProductController@categoryProducts');
    Route::get('products/{id}/comments', 'Joystick\ProductController@comments');
    Route::get('products/{id}/destroy-comment', 'Joystick\ProductController@destroyComment');

    Route::get('apps', 'Joystick\AppController@index');
    Route::get('apps/{id}', 'Joystick\AppController@show');
    Route::delete('apps/{id}', 'Joystick\AppController@destroy');
});

Route::get('test', function() {
    $arr_ru = [
        'Abay Residence', 'Apple Town', 'Айгерим', 'Ак Бота', 'Академия', 'Акмарал', 'Алмалы', 'Алма-Ата', 'Алматы Тауэрс', 'Алтын Заман', 'Алтын Орда', 'Аль-Фараби', 'Арай', 'Арман', 'Арман Вилла', 'Аскар Тау', 'Аскарбек', 'Астана', 'Ата', 'Аэлита', 'Баганашил Севен Старс', 'Базис на Зенкова', 'Базис на Чайковского', 'Байсал  мкр Баганашыл', 'Бес Тулга', 'Ботанический Cад', 'Ботанический Бульвар', 'Бухар Жырау Тауэрс', 'Байганина', 'Науаи', 'Гаухартас', 'Горная Долина', 'Горстрой', 'Долина роз', 'Дуэт', 'Европолис', 'Есентай Парк', 'Жагалау - 46 квартал', 'Жайлы', 'Жайляу', 'Жана Гасыр', 'Жастар', 'Жастар Атамекен', 'Жеруйык', 'Звезда Востока', 'Зеленая Долина', 'Изумрудный город', 'Импорио', 'КУАT на Достык', 'КУАТ на Барибаева', 'КУАТ на Ескараева', 'КУАТ на Масанчи', 'КУАТ на Гоголя', 'КУАТ на Сатпаева', 'КУАТ на Торайгырова', 'КУАТ на Фурманова', 'Каргалы', 'Керемет', 'Кокше', 'Максима Резидентс', 'Максима на Райымбека', 'Мега Сайран', 'Мега Тауэрс', 'Меркур Тауэрс', 'Меркур Град', 'НИКО на Сатпаева', 'НИКО на Навои', 'НИКО на Толе би', 'Наурыз', 'Ностальжи', 'Нурлы Тау', 'Овация', 'Парк Горького', 'Пионер', 'Премьера', 'Рапсодия', 'Ренессанс', 'Sun Villa ( Кумбель)', 'Салем', 'Самал де Люкc', 'Солнечная Долина', 'Столичный Центр', 'Сункар', 'Gorky Park Residence', 'Талисман', 'Тау Самал', 'Тау Самал на Навои', 'Театральный', 'Тенгиз Тауэрс', 'Терренкур', 'Триумф', 'Тюркуаз Тауэрс', 'Уштобе', 'Фантазия', 'White Fort', 'Хан-Тенгри', 'Цитадель', 'Шанырак', 'Шахристан', 'Эвон', 'Элит-1', 'Элит-2', 'Этюд', 'Южный Дуэт', 'Тау Самал', 'Прогрессстрой', 'Коркем Тау', 'Солнечный квартал', 'Версаль',
    ];
    $arr_en = ['Abay Residence', 'Apple Town', 'Aigerim', 'Ak Bota', 'Akademiya', 'Akmaral', 'Almaly', 'Alma-Ata', 'Almaty Towers ', 'Altyn Zaman', 'Altyn Orda', 'Al- Farabi', 'Aray', 'Arman', 'Arman Villa', 'Askar Tau', 'Askarbek', 'Astana', 'Ata', 'Aelita', 'Baganashyl Seven Stars', 'Bazis on Zenkov st.', 'Bazis on Chaikovskyi st.', 'Baisal Baganashyl district ', 'Bes Tulga', 'Botanycal Garden', 'Botanycal Boulevard    ', 'Bukhar Zhyrau Towers', 'Baiganina', 'Nauai', 'Gaykhar Tas', 'Gornaya Dolina', 'Gorstroy', 'Dolina Ros', 'Duet', 'Europolis', 'Esentay Park', 'Zhagalau – 46 blok', 'Zhaily', 'Zhailau', 'Zhana Gasyr', 'Zhastar', 'Zhastar Atameken', 'Zheruiek', 'Zvezda Vostoka', 'Green Valley', 'Emerald city', 'Imporio', 'Kuat on Dostyk  st.', 'Kuat on Barbaev st.', 'Kuat on Eskaraev st. ', 'Kuat on Masanchi st.', 'Kuat on Gogol st.', 'Kuat on Satpaev st.', 'Kuat on Toraygirov st.', 'Kuat on Furmanov st.', 'Kargaly', 'Keremet', 'Kokshe', 'Maxima Residence', 'Maxima on Raiymbek st.', 'Mega Sayran', 'Mega Towers', 'Merkur Towers', 'Merkur Grad', 'Niko on Satpaev st.', 'Niko on Nauai  st.', 'Niko on Tole bi st.', 'Nauryz', 'Nostalzhi', 'Nurly Tau', 'Ovatsiya', 'Park Gorkogo', 'Pioneer', 'Premiera', 'Rapsodiya', 'Renaissance', 'Sun Villa ( Cumbel)', 'Salem', 'Samal de Lux', 'Sunny Valley', 'Stolychnyi Center', 'Sunkar', 'Gorky Park Residence', 'Talisman', 'Tau Samal', 'Tau Samal on Nauai st.', 'Teatralnyi', 'Tengyz Towers', 'Terrencur', 'Triumph', 'Turkuaz Towers', 'Ushtobe', 'Fantasia', 'White Fort', 'Khan-Tengry', 'Citadel', 'Shanyrac', 'Shakhristan', 'Avon', 'Elit - 1', 'Elit - 2', 'Etud', 'South Duet', 'Tau Samal', 'Progress stroy', 'Korkem Tau', 'Solnechniy kvartal', 'Versal'];

    $titles = [];
    $data = [];
    $languages = [];

    foreach ($arr_ru as $key_ru => $value_ru) {
        $titles['ru']['title'] = $value_ru;
        $data['ru']['data'] = 'Жилищный комплекс';
        $languages['ru'] = 'ru';
        
        $titles['en']['title'] = $arr_en[$key_ru];
        $data['en']['data'] = 'Residential Complex';
        $languages['en'] = 'en';

        $option = new \App\Option;
        $option->sort_id = $option->count() + 1;
        $option->slug = str_slug($value_ru);
        $option->title = serialize($titles);
        $option->data = serialize($data);
        $option->lang = serialize($languages);
        $option->save();
        echo $key_ru.' - '.$titles['ru']['title'].' --- '.$titles['en']['title'].'<br>';
        echo $key_ru.' - '.$languages['ru'].' --- '.$languages['en'].'<br>';
        echo $key_ru.' - '.$data['ru']['data'].' --- '.$data['en']['data'].'<hr>';
    }

    dd(11);

});

Route::redirect('/', '/'.app()->getLocale());
Route::redirect('/home', '/'.app()->getLocale().'/home');

// Site
Route::group(['prefix' => '{lang}'], function () {

    Auth::routes();

    // News
    Route::get('i/news', 'NewsController@news');
    Route::get('news/{page}', 'NewsController@newsSingle');
    Route::post('comment-news', 'NewsController@saveComment');

    // Pages
    Route::get('/', 'PageController@index');
    Route::get('i/catalog/{condition?}', 'PageController@catalog');
    Route::get('i/contacts', 'PageController@contacts');
    Route::get('i/{page}', 'PageController@page');

    // Shop
    // Route::get('/', 'ShopController@index');
    // Route::get('brand/{company}', 'ShopController@brandProducts');
    // Route::get('brand/{company}/{category}/{id}', 'ShopController@brandCategoryProducts');
    Route::get('c/{category}/{id}', 'ShopController@categoryProducts');
    // Route::get('c/{category}/{subcategory}/{id}', 'ShopController@subCategoryProducts');
    Route::get('p/{product}', 'ShopController@product');
    Route::post('comment-product', 'ShopController@saveComment');

    // Input
    Route::get('search', 'InputController@search');
    Route::get('search-ajax', 'InputController@searchAjax');
    Route::post('filter-products', 'InputController@filterProducts');
    Route::post('send-app', 'InputController@sendApp');
});
// Cart Actions
// Route::get('cart', 'CartController@cart');
// Route::get('add-to-cart/{id}', 'CartController@addToCart');
// Route::get('remove-from-cart/{id}', 'CartController@removeFromCart');
// Route::get('clear-cart', 'CartController@clearCart');
// Route::post('store-order', 'CartController@storeOrder');
// Route::get('destroy-from-cart/{id}', 'CartController@destroy');


// Favourite Actions
Route::get('favorite', 'FavouriteController@getFavorite');
Route::get('toggle-favourite/{id}', 'FavouriteController@toggleFavourite');
