@extends('app')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
                                        
                                    <?

                                        if(isset($id)){
                                                echo "<p id='userid' value='".$id."'>$id</p>";
                                        }else{
                                                 echo "Добавить данные";
                                        }

                                    ?>

                                </div>

				<div class="panel-body">
					<select size="1" name="country"  style="float:left;">
					<option value="">Все страны</option>
					<optgroup label="Выберите страну">
					<?
					//print_r($cities);
					foreach ($cities as $city) {
						echo "<option value='".$city['id']."'>".$city['title']."</option>";
					}

					?>
					</optgroup>
					</select>

					<select name="city" style="float:right;" id="city">
                                                <option value="">Все города</option>                                 
                                        </select>

                                        <br><br><p>Ваш язык:&nbsp;<input type="text" name="language" id="language"></p>
				        
                                        <?   if(isset($id)){
                                                echo "<button class='btn btn-primary' id='update'>Обновить</button>";
                                             }else{
                                                echo "<button class='btn btn-primary' id='add'>Добавить</button>";
                                             }
                                        ?>

                                    <p id="result"></p> 

                                    <a href="<?=url('/');?>" role="button" class="btn btn-primary">На главную</a>     
                                
                                </div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	
	$(document).ready(function(){

                var userlanguage = navigator.language;

                $('#language').val(userlanguage);
                

                $('#add').on('click',function(){

                        var lang = $('#language').val();
                        var country = $('select[name="country"] option:selected').text();
                        var city = $('select[name="city"]').val();
                        
                        var data = {"language":lang,"country":country,"city":city}
                        var datatojson = JSON.stringify(data);


                        $.ajax({
                                type: "POST",
                                url: "/addtodb",
                                data: { jsondata:datatojson},
                                cache: false,
                                success: function(responce){ 
                                        $("#result").text(responce);
                                }
                        });
                });

                $('#update').on('click',function(){

                        var userid = $('#userid').text();
                        var lang = $('#language').val();
                        var country = $('select[name="country"] option:selected').text();
                        var city = $('select[name="city"]').val();
                        
                        var data = {"language":lang,"country":country,"city":city,"userid":userid}
                        
                        var datatojson = JSON.stringify(data);

                        $.ajax({
                                type: "POST",
                                url: "/update",
                                data: { jsondata:datatojson},
                                cache: false,
                                success: function(responce){ 
                                        $("#result").text(responce);
                                }
                        });
                });
	});

        $('select[name="country"]').on('change',function(){

                var id_country = $('select[name="country"]').val();

                if(!id_country){
                        $('div[name="selectDataRegion"]').html('');
                        $('div[name="selectDataCity"]').html('');
                }else{
                        console.log("here");
                        $.ajax({
                                type: "POST",
                                url: "/getcitieslist",
                                data: { action: 'citieslist', id_country: id_country },
                                cache: false,
                                success: function(responce){ 
                                   
                                    var res = JSON.parse(responce);

                                    for(var i = 0;i<res.length;i++){
                                        
                                        $('#city').append("<option value='"+res[i].title+"'>"+res[i].title+"</option>");
                                        
                                    }
                                    
                                }
                        });
                }
        });


</script>
@endsection