<div class="modal modal-primary fade" id="create-modal-images" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2"><b>Enviar a revision</b></h4>
            </div>
            <div class="modal-body">
                <?php $tam=count($imagens);$i=0?>
                @while($i<$tam)
                        <br><br>
                    <div class="row">
                        @if($i<$tam)
                            <div class="col-xs-4">
                                <div class="portfolio-item">
                                    {!! Html::image($imagens[$i]->image,null,["width"=>"200px","heigth"=>"200px","id"=>"img".$imagens[$i]->id,"onclick"=>"clickimage(this.id,".$imagens[$i]->id.")"]) !!}
                                </div>
                            </div>
                        @endif
                        <?php $i++;?>
                        @if($i<$tam )
                            <div class="col-xs-4">
                                <div class="portfolio-item">
                                    {!! Html::image($imagens[$i]->image,null,["width"=>"200px","heigth"=>"200px","id"=>"img".$imagens[$i]->id,"onclick"=>"clickimage(this.id,".$imagens[$i]->id.")"]) !!}
                                </div>
                            </div>
                        @endif
                        <?php $i++;?>
                        @if($i<$tam )
                            <div class="col-xs-4">
                                <div class="portfolio-item">
                                    {!! Html::image($imagens[$i]->image,null,["width"=>"200px","heigth"=>"200px","id"=>"img".$imagens[$i]->id,"onclick"=>"clickimage(this.id,".$imagens[$i]->id.")"]) !!}
                                </div>
                            </div>
                        @endif
                        <?php $i++;?>
                    </div>
                @endwhile
                    <button type="button" class="btn btn-lg btn-success" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">listo</span>
            </div>

        </div>
    </div>
</div>