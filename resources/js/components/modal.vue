<template>
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="ticket modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centerd" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <slot name="body"> </slot>
                </div>
                <div class="modal-footer">
                    <slot name="footer"> </slot>
                </div>
            </div>
        </div>
    </div>
</template>
