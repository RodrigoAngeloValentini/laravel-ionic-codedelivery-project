## LARAVEL 5.1 COM IONIC + CORDOVA - BF

Problemas:

####Middleware: CheckRole()
Auth::check() e Auth::user() não estão funcionando

####Create e Edit Clients
Erro ao criar e editar clientes

#####Erro ao criar seed ordem item
Unable to locate factory with name [default] [OrdermItem].
<br>
Mesmo com isso: 
<br>
$factory->define(CodeDelivery\Models\OrderItem::class, function (Faker\Generator $faker) {<br>
    return [];<br>
});

#####Não edita entragador pedido
Não atualiza o entregador pedido