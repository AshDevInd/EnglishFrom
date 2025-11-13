
<ul class="bottom_links">
        <li><a href="https://hindi2.com/">Hindi2</a></li>
        <li><a href="#">English2desi</a></li>
        <li><a href="<?=base_url()?>Khmer_characters_in_MD_and_English/">Khmer MD & Roman</a></li>
        <li><a href="<?=base_url()?>script_choice/">Script Choice</a></li>
        <li><a href="<?=base_url()?>khmer-script" >
          Khmer Script
        </a></li>
        <li><a href="md_english_consonants" type="button" target="_blank">
          MD English Consonants
        </a></li>
        <li><a href="English_Devanagari_Vowels" type="button" target="_blank">
           English Devanagari Vowels        </a>
        </li>
      </ul>
      </section>
      <section class="banner_bg">
      
          <div class="container-fluid">
            <div class="row">
            
              <div class="col-md-12">
                <div class="banner_sec" style="padding-top:50px">
                <h1><?=$cat['cat_name']?></h1>

                <!-- <h3><span>MD = Modified Devanagari</span>  <span>MK = Modified Khmer</span>
                  <span>IPA = International Phonetic Alphabet</span></h3> -->

                  <div class="row">

                  <?php foreach($archive as $arc) { ?>
                    <div class="col-md-2 mb-5">
                      <a href="<?=base_url($arc['path_name'])?>"><?=$arc['archive_name']?></a>
                    </div>
                  <?php } ?>

                  </div>
              

            </div>
          </div>
        </div>
      </div>
      </section>
      


