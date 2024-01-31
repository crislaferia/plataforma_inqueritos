<link rel="stylesheet" href="css/menulateral.css" />

<div class="menu">
                <div class="menu-item">
                    <img src="img/Vector.png" width= 25px>
                    <a href="index.php" class="menu-link" aria-current="page" >Inicio</a>
                </div>
                <div class="menu-item">
        
        <img src="img/forms.png" width= 25px>
        <!-- Adicione a classe 'accordion' para criar o accordion -->
        <div class="accordion" id="formsAccordion">
            
            <div class="accordion-item" >
                
                <!-- Adicione a classe 'accordion-button' e os atributos necessários para criar o botão do accordion -->
                <h2 class="accordion-header"  >
                    
                    <button id="formsbutton" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#formsCollapse" aria-expanded="true" aria-controls="formsCollapse">
                        Formulários
                    </button>
                </h2>
                
                <!-- classe 'accordion-collapse' e os atributos necessários para criar a área de conteúdo do accordion -->
                <div id="formsCollapse" class="accordion-collapse collapse" data-bs-parent="#formsaccordion">
                    <div class="accordion-body" >
                        <div class="accordion-item" style="color: #FFFFFF;">
                        <!--links dentro da área de conteúdo do accordion -->
                        <li><a href="criar_form.php" class="dropdown-item">Criar</a></li>
                        <hr></hr>
                        <li><a href="cons_form.php" class="dropdown-item">Consultar</a></li>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <div class="menu-item">
        <img src="img/Frame.png" width= 25px style="padding-left:3px">
        <a href="estatisticas.php" class="menu-link">Estatisticas</a>
    </div>
</div>
