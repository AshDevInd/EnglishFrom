<h1 class="pt-5 text-center titulo mid_heading">Khmer Script</h1>
<div class="container">

  <!-- Horizontal Vowel Bar -->
  <div class="khmer-vowel-bar my-3">
    <?php foreach ($vowel_grp as $index => $vocab): ?>
      <button
        class="khmer-vowel-btn<?php echo $index === 0 ? ' active' : ''; ?>"
        data-vowel="<?php echo htmlspecialchars($vocab['vowel']); ?>">
        <?php echo !empty($vocab['vowel']) ? '(' . htmlspecialchars($vocab['vowel']) . ')' : '( )'; ?>
      </button>
    <?php endforeach; ?>
  </div>

  <div class="d-flex align-items-start my-4">
    <!-- Sidebar Vertical Nav -->
    <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical" style="height: 10%;">
      <?php foreach ($total_vocab as $index => $vocab): ?>
        <button
          class="nav-link<?php echo $index === 0 ? ' active' : ''; ?>"
          id="v-pills-tab-<?php echo $index; ?>"
          data-bs-toggle="pill"
          data-bs-target="#v-pills-<?php echo $index; ?>"
          type="button"
          role="tab"
          aria-controls="v-pills-<?php echo $index; ?>"
          aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>"
          data-vowel="<?php echo htmlspecialchars($vocab['vowel']); ?>">
          <?php echo $vocab['serial_number']; ?> (<?php echo $vocab['vowel']; ?>)
        </button>
      <?php endforeach; ?>
    </div>

    <!-- Tab Content -->
    <div class="tab-content" id="v-pills-tabContent" style="flex: 1;">
      <?php foreach ($total_vocab as $indexVocab => $vocabs): ?>
        <div
          class="tab-pane fade<?php echo $indexVocab === 0 ? ' show active' : ''; ?>"
          id="v-pills-<?php echo $indexVocab; ?>"
          role="tabpanel"
          aria-labelledby="v-pills-tab-<?php echo $indexVocab; ?>"
          data-vowel="<?php echo htmlspecialchars($vocabs['vowel']); ?>">
          <div class="sv-tab-panel">
            <div class="table-responsive">
              <table class="waffle">
                <thead>
                  <tr style="height: 20px">
                    <td></td>
                    <td></td>
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

<style>
.khmer-vowel-bar {
  display: flex;
  gap: 10px;
  overflow-x: auto;
  white-space: nowrap;
  background: #f5fafd;
  padding: 10px 7px;
  border-bottom: 1px solid #e0e0e0;
  margin-bottom: 24px;
}
.khmer-vowel-btn {
  min-width: 48px;
  padding: 8px 14px;
  background: #e0e0e0;
  color: #222;
  border-radius: 5px;
  border: none;
  outline: none;
  font-size: 1rem;
  text-align: center;
  cursor: pointer;
  transition: background 0.2s, color 0.2s;
  margin: 0;
}
.khmer-vowel-btn.active,
.khmer-vowel-btn:focus,
.khmer-vowel-btn:hover {
  background: #0096ff;
  color: #fff;
}
</style>

<script>
$(document).ready(function() {
    function activateSidebarTab($btn) {
        if($btn.length) {
            $('.nav-pills .nav-link').removeClass('active'); // Remove from all
            $btn.removeClass('active'); // make sure not active
            $btn.tab('show');
        }
    }

    function filterByVowel(vowel) {
        var $visibleSidebarBtns = [];
        $('.nav-pills .nav-link').each(function() {
            var $this = $(this);
            if ($this.data('vowel') === vowel) {
                $this.show();
                $visibleSidebarBtns.push($this);
            } else {
                $this.hide().removeClass('active');
            }
        });
        $('.tab-pane').removeClass('show active');
        if ($visibleSidebarBtns.length) {
            // Remove .active from all, then force tab show to re-trigger bootstrap logic
            setTimeout(function(){
                activateSidebarTab($($visibleSidebarBtns[0]));
            }, 0);
        }
    }

    // On page load: ensure only topbar "active", not sidebar
    $('.nav-pills .nav-link').removeClass('active');
    var $initialVowelBtn = $('.khmer-vowel-btn.active');
    if(!$initialVowelBtn.length) {
        $initialVowelBtn = $('.khmer-vowel-btn').first().addClass('active');
    }
    filterByVowel($initialVowelBtn.data('vowel'));

    // On top bar click
    $('.khmer-vowel-btn').click(function() {
        var $this = $(this);
        $('.khmer-vowel-btn').removeClass('active');
        $this.addClass('active');
        filterByVowel($this.data('vowel'));
    });
});

</script>
