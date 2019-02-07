<?php 
    $moyenne_display = studentMoyenne($user_id);
?>
<div class="card">
    <div class="header">
        <h4 class="title">Vos dernières notes</h4>
        <h5><?php echo $moyenne_display; ?></strong></h5>
        
    </div>
    <div class="content table-responsive table-full-width">
        <table class="table table-hover table-striped">
            <thead>
                <th>Matière</th>
                <th>Note</th>
                <th>Professeur</th>
                <th>Commentaire</th>
            </thead>
            <tbody>
                <?php studentDisplayNotes($user_id); ?>
            </tbody>
        </table>

    </div>
</div>
