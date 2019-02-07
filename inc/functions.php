<?php
    // Affichage des news
    function studentDisplayNews(){
        global $mysqli;
        $news_request = "SELECT * FROM news_feed ORDER BY id ASC LIMIT 6";
        if($resultat_news = $mysqli->query($news_request) ){
            while( $res = $resultat_news->fetch_object()){
                $news_title = $res->news_title;
                $news_url = $res->news_link_external;
            ?>
                <tr>
                    <td>
                        <div class="checkbox">
                            <input id="checkbox1" type="checkbox">
                            <label for="checkbox1"></label>
                        </div>
                    </td>
                    <td>
                    <?php 
                        if($news_url !== ''){ echo '<a href="'.$news_url.'"target="_blank">'; }
                        echo $news_title;
                        if($news_url !== ''){ echo '</a>'; }
                    ?>
                    </td>
                    <td class="td-actions text-right">
                        <button type="button" rel="tooltip" title="Edit Task" class="btn btn-info btn-simple btn-xs">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                            <i class="fa fa-times"></i>
                        </button>
                    </td>
                </tr>
            <?php
            }
        }
    }
    function studentDisplayNotes($id){
        global $mysqli;
        $student_notes_request = "SELECT * FROM notes WHERE note_user_id = '".$id."' LIMIT 7";
        if($resultat_notes = $mysqli->query($student_notes_request) ){
            while( $res = $resultat_notes->fetch_object()){
                $matiere = $res->note_matiere_id;
                $matiere_request = "SELECT * FROM matieres WHERE id = '".$matiere."'";
                if($mat_notes = $mysqli->query($matiere_request) ){
                    while( $res2 = $mat_notes->fetch_object()){
                       $matiere_name = $res2->matieres_name;
                    }
                }
                $prof = $res->note_prof_id;
                $prof_request = "SELECT * FROM users WHERE id = '".$prof."'";
                if($prof_notes = $mysqli->query($prof_request) ){
                    while( $res3 = $prof_notes->fetch_object()){
                        $prof_name = $res3->users_surname.' '.$res3->users_name;
                        $prof_email = $res3->users_email;
                    }
                }
            ?>
               <tr>
                    <td> <?php echo $matiere_name; ?></td>
                    <td><?php echo $res->note_note; ?> / 5</td>
                    <td><a href="profile.php?id=<?php echo $prof; ?>"><?php echo $prof_name; ?></a></td>
                    <td><?php echo $res->note_commentaire; ?></td>
               </tr>
            <?php
            }
        }
    }


    function studentMoyenne($id){
        global $mysqli;
        $student_notes_request = "SELECT * FROM notes WHERE note_user_id = '".$id."'";
        if($resultat_notes = $mysqli->query($student_notes_request) ){
            $moyenne = 0;
            $nbr_notes = $resultat_notes->num_rows;
            while( $res = $resultat_notes->fetch_object()){
                $moyenne += $res->note_note;
            }
            if($nbr_notes >= 1){
                $moyenne = $moyenne / $nbr_notes;
                $moyenne_arrondie = round($moyenne);
                $moyenne = "Votre moyenne: <strong>".$moyenne."/5</strong>.";
                switch ($moyenne_arrondie):
                    case 0:
                        $moyenne .= '<span class="small">Vraiment merdique...</span>';
                        break;
                    case 1:
                        $moyenne .= '<span class="small">Vraiment pas terrible...</span>';
                        break;
                    case 2:
                        $moyenne .= '<span class="small">Presque sauvé...</span>';
                        break;
                    case 3:
                        $moyenne .= '<span class="small">De justesse...</span>';
                        break;
                    case 4:
                        $moyenne .= '<span class="small">Bravo petit champion...</span>';
                        break;
                    case 5:
                        $moyenne .= '<span class="small">Welcome Einstein...</span>';
                        break;
                    default:
                        $moyenne .= '';
                endswitch;
            }else{
                $moyenne = "Vous n'avez pas encore de notes.";
            }
            return $moyenne;
        }
    }


?>