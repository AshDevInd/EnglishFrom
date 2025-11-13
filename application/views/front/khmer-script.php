<h1 class="pt-5 text-center titulo mid_heading">Khmer Script </h1>
  <div class="container">
    
    <div class="d-flex align-items-start my-4">
  <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
    <?php foreach ($total_vocab as $index => $vocab): ?>
      <button class="nav-link <?php echo $index === 0 ? 'active' : ''; ?>"
              id="v-pills-tab-<?php echo $index; ?>"
              data-bs-toggle="pill"
              data-bs-target="#v-pills-<?php echo $index; ?>"
              type="button"
              role="tab"
              aria-controls="v-pills-<?php echo $index; ?>"
              aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>">
        <?php echo $vocab['serial_number']; ?> (<?php echo $vocab['vowel']; ?>)
      </button>
    <?php endforeach; ?>
  </div>

  <div class="tab-content" id="v-pills-tabContent">
    <?php foreach ($total_vocab as $indexVocab => $vocabs): ?>
      <div class="tab-pane fade <?php echo $indexVocab === 0 ? 'show active' : ''; ?>"
           id="v-pills-<?php echo $indexVocab; ?>"
           role="tabpanel"
           aria-labelledby="v-pills-tab-<?php echo $indexVocab; ?>">

        <div class="sv-tab-panel">
            <div class="table-responsive">
          <table class="waffle">
            <thead>
              <tr style="height: 20px">
                <td class="s0"> </td>
                <td class="s0"></td>
                <td class="s1">script</td>
                <td class="s1">script</td>
                <td class="s1">script</td>
                <td class="s1">script</td>
              </tr>
              <tr>
                <td class="s9">sound #</td>
                <td class="s9">combination</td>
                <td class="s10">Khmer</td>
                <td class="s10">Devanagari</td>
                <td class="s10">Roman</td>
                <td class="s10">IPA</td>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($vocabs['data'] as $vocab): ?>
                <tr>
                  <td class="s3"><?php echo $vocab['serial_number']; ?></td>
                  <td class="s3"><?php echo $vocab['combination']; ?></td>
                  <td class="s4"><?php echo $vocab['khmer']; ?></td>
                  <td class="s4"><?php echo $vocab['devanagari']; ?></td>
                  <td class="s4"><?php echo $vocab['roman']; ?></td>
                  <td class="s4"><?php echo $vocab['ipa']; ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          </div>
        </div>

      </div>
    <?php endforeach; ?>
  </div>
</div>
    
  </div>
  </section>
  