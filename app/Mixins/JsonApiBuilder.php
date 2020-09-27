<?php 
namespace App\Mixins;

use Illuminate\Support\Str;


    Class JsonApiBuilder {

      public function jsonPaginate(){
          return function(){
                return       $this->paginate( 
                          $perpage = request('page.size') ,
                          $columns = ['*'],
                          $pageName ='page[number]',
                          $page     = request('page.number')
                      )->appends( request()->except('page.number') ); /// Adiciona esta parte a la respuesta          
          };
        } 
  

        public function applySorts () {
            return function() {
                if ( !property_exists ( $this->model, 'allowedSorts') )  {
                    abort(500,'Allowed property missing !. Add this property to :' . get_class($this->model)) ;
                }

                if  (is_null($sort = request('sort')  ))  return $this;
                
                $sortFields   = Str::of( $sort )->explode(',') ;  // Campo por el que ordeno
                
                foreach ($sortFields as $sortField) {
                    $direction = 'asc';                                  // Orden por defecto
                        if ( Str::of( $sortField)->startsWith('-') ) {
                            $direction ='desc';
                            $sortField = Str::of ($sortField)->substr(1);       // Convierte a un objecto string y quita el primer caracter
                        }

                        // preguntamos si los campos de ordenamiento requeridos están permitidos.
                        if ( !collect ( $this->model->allowedSorts)->contains($sortField  )) {
                            abort(400,'Invalid sort field');
                        }

                        $this->orderby($sortField, $direction  );            
                    }
                    return $this;
            };
        }

        public function applyFilters() {
            return function() {
                foreach (request('filter',[]) as $filter => $value) {        //request('filter',[])  Contiene los campos de búsqueda o un array vacío
                    abort_unless ( 
                        $this->hasNamedScope ( $filter),  400, "The filter {$filter } has not been allowed."                  
                     );
                  $this->{$filter}($value) ;            
                }
                return $this;  //  Hace referencia al query builder
            };
        }


    }
?>