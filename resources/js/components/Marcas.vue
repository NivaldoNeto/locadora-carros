<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
            
                <!-- inicio do card de busca -->
                <card-component titulo="Busca de marcas">
                    <template v-slot:conteudo>
                        <div class="row g-3" >
                            <div class="col mb-3">
                                <input-container-component titulo="ID" id="inputId" id-help="idHelp" texto-ajuda="Opcional. Informe o ID do registro!">
                                    <input type="number" class="form-control" id="inputID" aria-describedby="idlHelp" placdeholder="ID">
                                </input-container-component>
                            </div>
                            <div class="col mb-3">
                                <input-container-component titulo="Nome da marca" id="inputNome" id-help="nomeHelp" texto-ajuda="Opcional. Informe o nome da marca!">
                                    <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placdeholder="Nome da Marca">
                                </input-container-component>
                            </div> 
                        </div>
                    </template>
                    
                    <template v-slot:rodape>
                        <button type="submit" class="btn btn-primary btn-sm float-right">Pesquisar</button>
                    </template>
                </card-component>
                <!-- fim do card de busca -->
                
                <!-- fim do card de listagem de marcas -->
                <card-component titulo="Relação de Marcas">
                    <template v-slot:conteudo> 
                        <table-component></table-component>
                    </template>

                    <template v-slot:rodape>
                        <button type="submit" class="btn btn-primary btn-sm float-right" data-bs-toggle="modal" data-bs-target="#marcaModal">Adicionar</button>
                    </template>
                </card-component>
                <!-- fim do card de listagem de marcas -->
            </div>
        </div>
        <modal-component id="marcaModal" titulo="Adiciona Marca">
            <div class="form-group">
                <input-container-component titulo="Nome da marca" id="novoNome" id-help="nomeHelp" texto-ajuda="Opcional. Informe o nome da marca!">
                    <input type="text" class="form-control" id="novoNome" aria-describedby="nomeHelp" placdeholder="Nome da Marca">
                </input-container-component>
            </div>

            <div class="form-group">
                <input-container-component titulo="Nome da marca" id="inputNome" id-help="nomeHelp" texto-ajuda="Opcional. Informe o nome da marca!">
                    <input type="file" class="form-control" id="inputNome" aria-describedby="nomeHelp" placdeholder="Nome da Marca">
                </input-container-component>
            </div>
            

        </modal-component>
    </div>
</template>

<script>
    
</script>
