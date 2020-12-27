var app = angular.module('myApp',['ngRoute']);

app.config(function($routeProvider)
{
 $routeProvider

 .when('/home', {
   templateUrl : 'app/views/home.htm',
})

 .when('/tira_duvidas', {
   templateUrl : 'app/views/tira_duvidas.htm',
})

 .when('/perfil', {
   templateUrl : 'app/views/perfil.htm',
})



   // cadastro usuario
   .when('/cadastro', {
      templateUrl : 'app/views/cadastro.htm',
   })
   
   .when('/cadastro_usuario', {
      templateUrl : 'app/views/cadastro_usuario.htm',
   })


   // Caminhões
   .when('/caminhoes', {
      templateUrl : 'app/views/caminhoes.htm',
   })

   .when('/cadastro_caminhao', {
      templateUrl : 'app/views/cadastro_caminhao.htm',
   })
   
   .when('/editar_caminhao', {
      templateUrl : 'app/views/editar_caminhao.htm',
   })


   // Terceiros
   .when('/terceiros', {
      templateUrl : 'app/views/terceiros.htm',
   })
   
   .when('/cadastro_terceiros', {
      templateUrl : 'app/views/cadastro_terceiros.htm',
   })
   
   .when('/editar_terceiros', {
      templateUrl : 'app/views/editar_terceiros.htm',
   })



   // Empresas
   .when('/empresas', {
      templateUrl : 'app/views/empresas.htm',
   })

   .when('/cadastro_empresa', {
      templateUrl : 'app/views/cadastro_empresa.htm',
   })

   .when('/editar_empresa', {
      templateUrl : 'app/views/editar_empresa.htm',
   })



   // Proprietario 
   .when('/proprietario', {
      templateUrl : 'app/views/proprietario.htm',
   })

   .when('/cadastro_proprietario', {
      templateUrl : 'app/views/cadastro_proprietario.htm',
   })

   .when('/editar_proprietario', {
      templateUrl : 'app/views/editar_proprietario.htm',
   })



   // Bomba 
   .when('/bomba', {
      templateUrl : 'app/views/bomba.htm',
   })

   .when('/cadastro_bomba', {
      templateUrl : 'app/views/cadastro_bomba.htm',
   })

   .when('/editar_bomba', {
      templateUrl : 'app/views/editar_bomba.htm',
   })



   // entrada
   .when('/entrada', {
      templateUrl : 'app/views/entrada.htm',
   })

   .when('/cadastro_entrada', {
      templateUrl : 'app/views/cadastro_entrada.htm',
   })

   .when('/editar_entrada', {
      templateUrl : 'app/views/editar_entrada.htm',
   })


   // saida
   .when('/saida', {
      templateUrl : 'app/views/saida.htm',
   })

   .when('/cadastro_saida', {
      templateUrl : 'app/views/cadastro_saida.htm',
   })

   .when('/editar_saida', {
      templateUrl : 'app/views/editar_saida.htm',
   })
   
   .when('/cupom', {
      templateUrl : 'app/views/cupom.htm',
   })
   
   .when('/fitinha', {
      templateUrl : 'app/views/fitinha.htm',
   })
   
   .when('/acerto', {
      templateUrl : 'app/views/acerto.htm',
   })


   // Média  
   .when('/media', {
      templateUrl : 'app/views/media.htm',
   })

   
   // Relatorio
   .when('/relatorio', {
      templateUrl : 'app/views/relatorio.htm',
   })

   .otherwise ({ redirectTo: '/home' });
});