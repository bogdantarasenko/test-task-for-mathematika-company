@extends('app')

@section('content')

        <div class="container">
            <div class="content">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Страна</th>
                        <th>Город</th>
                        <th>Язык</th>
                        <th>изменить</th>
                        <th>удалить</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                    <?foreach($data as $userdata){
                        $id = $userdata->id;
                        $city = $userdata->city;
                        $country = $userdata->country;
                        $language = $userdata->language;
                        echo "
                            <tr>
                              <td>$country</td>
                              <td>$city</td>
                              <td>$language</td>
                              <td><a href='".url("/update",[$id],$secure = null)."'>изменить</a></td>
                              <td><a href='".url("/delete",[$id],$secure = null)."'>удалить</a></td>
                            </tr>";

                    }?>
                    </tr>
                    </tbody>
                </table>
                <a href="<?=url('/add');?>" role="button" class="btn btn-primary">Добавить</a>
            </div>
        </div>
@endsection