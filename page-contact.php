<?php
/*
Template Name: Page Contact
*/
get_header();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérez les données du formulaire
    $nom = sanitize_text_field($_POST["nom"]);
    $prenom = sanitize_text_field($_POST["prenom"]);
    $email = sanitize_email($_POST["email"]);
    $telephone = sanitize_text_field($_POST["telephone"]);
    $sujet = sanitize_text_field($_POST["sujet"]);
    $consentement = isset($_POST["consentement"]) ? sanitize_text_field($_POST["consentement"]) : '';
    $visitorIp = getVisitorIp();

    if(!isIpFrench($visitorIp)){
        die;
    }


    $website_field = $_POST["website"];
    if (!empty($website_field)) {
        echo '<p>Votre formulaire a été détecté comme du spam. Veuillez réessayer.</p>';
        die;
    }

    // Vérifiez le consentement
    if (empty($consentement)) {
        echo '<p>Veuillez donner votre consentement en cochant la case.</p>';
    } else {
        // Créez un tableau avec toutes les données du formulaire
        $contact_content = "Nom: $nom\nPrénom: $prenom\nEmail: $email\nTéléphone: $telephone\nSujet: $sujet\nConsentement: Oui";

        // Créez un tableau avec les données du formulaire pour les champs personnalisés (si nécessaire)
        $contact_data = array(
            'post_title'   => $nom . ' ' . $prenom,
            'post_content' => $contact_content,
            'post_status'  => 'draft',
            'post_type'    => 'contact',
            'meta_input'   => array(
                'nom'         => $nom,
                'prenom'      => $prenom,
                'email'       => $email,
                'telephone'   => $telephone,
                'sujet'       => $sujet, // Ajoutez le sujet comme champ personnalisé si nécessaire
                'consentement' => $consentement,
            ),
        );

        // Insérez le nouveau post dans la base de données
        $post_id = wp_insert_post($contact_data);

        if ($post_id) {
            $returnMesage =  '<p>Votre demande de contact a été enregistrée avec succès.</p>';
        } else {
            $returnMesage =  '<p>Une erreur s\'est produite. Veuillez réessayer.</p>';
        }
    }
}



if( have_rows('page') ):
    while ( have_rows('page') ) : the_row();
        get_template_part('template-parts/strates/' . get_row_layout());
    endwhile;
endif;

?>

<div class="container" id="form">
    <div class="row">
        <div class="col-sm-9 mx-auto">

            <?php if(isset($returnMesage)): ?>
            <div class="return-message">
                <h3>Merci !</h3>
                <?= $returnMesage; ?>
            </div>
            <?php else: ?>
            <form method="post" class="row contact-form" action="#form">
                <div class="col-sm-6">
                    <label for="nom">Nom *</label>
                    <input type="text" name="nom" required>
                </div>

                <div class="col-sm-6">
                    <label for="prenom">Prénom *</label>
                    <input type="text" name="prenom" required>
                </div>

                <div class="col-sm-6">
                    <label for="email">Email *</label>
                    <input type="email" name="email" required>
                </div>

                <div class="col-sm-6">
                    <label for="telephone">Téléphone</label>
                    <input type="tel" name="telephone">
                </div>

                <div class="col-sm-12">
                    <label for="sujet">Sujet *</label>
                    <textarea name="sujet" required></textarea>
                </div>

                <div class="col-sm-12">
                    <label for="consentement">
                        <input type="checkbox" id="consentement" name="consentement" value="oui" required>
                        J'accepte que mes données soient enregistrées chez The Fox Agency
                    </label>
                </div>
                <div style="display: none;">
                    <label for="website">Laissez ce champ vide :</label>
                    <input type="text" name="website" id="website">
                </div>

                <div class="col-sm-12 text-center">
                    <input type="submit" class="button" value="Envoyer">
                </div>
            </form>
            <?php endif; ?>
        </div>
    </div>
</div>


<?php get_footer();
