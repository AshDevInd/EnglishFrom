<section>
<h1 class="pt-5 text-center titulo mid_heading">Khmer Script</h1>
<div class="container">
  <div class="d-flex align-items-start my-4">
    
    <!-- Sidebar navigation -->
    <div class="nav flex-column nav-pills me-3" id="vocab-sidebar" role="tablist" aria-orientation="vertical">

      <?php foreach ($total_vocab as $index => $group): ?>
        <?php if (in_array($group['category'], ['Consonant(S1)', 'Consonant(S2)'])): ?>
          <button class="nav-link <?php echo $index === 0 ? 'active' : ''; ?>"
                  id="sidebar-tab-<?php echo $index; ?>"
                  data-bs-toggle="pill"
                  data-bs-target="#tab-content-<?php echo $index; ?>"
                  type="button"
                  role="tab"
                  aria-controls="tab-content-<?php echo $index; ?>"
                  aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>" style="min-width: 220px;">
            <?php echo $group['category']; ?>
            <?php if (!empty($group['vowel'])): ?>
              <small > (<?php echo $group['vowel']; ?>)</small>
            <?php endif; ?>
          </button>
        <?php else: ?>
          <div class="accordion" id="accordion-<?php echo $index; ?>">
            <div class="accordion-item" style="min-width: 200px;">
              <h2 class="accordion-header" id="heading-<?php echo $index; ?>">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse-<?php echo $index; ?>" aria-expanded="false"
                        aria-controls="collapse-<?php echo $index; ?>" style="font-weight: 600;">
                  <?php echo $group['category']; ?>
                  <?php if (!empty($group['vowel'])): ?>
                    <small> (<?php echo $group['vowel']; ?>)</small>
                  <?php endif; ?>
                </button>
              </h2>
              <div id="collapse-<?php echo $index; ?>" class="accordion-collapse collapse"
                   aria-labelledby="heading-<?php echo $index; ?>" data-bs-parent="#accordion-<?php echo $index; ?>">
                <div class="accordion-body px-2 py-1">
                  <?php foreach ($group['serials'] as $si => $serial): ?>
                    <button class="nav-link ms-4"
                            id="sidebar-serial-<?php echo $index . '-' . $si; ?>"
                            data-bs-toggle="pill"
                            data-bs-target="#tab-content-<?php echo $index . '-' . $si; ?>"
                            type="button"
                            role="tab"
                            aria-controls="tab-content-<?php echo $index . '-' . $si; ?>"
                            aria-selected="false">
                      <?php echo $serial['serial_number']; ?>
                      <?php if (!empty($serial['vowel'])): ?>
                        <small> (<?php echo $serial['vowel']; ?>)</small>
                      <?php endif; ?>
                    </button>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>

    </div>

    <!-- Content panes -->
    <div class="tab-content flex-grow-1 ps-4" id="vocab-tabContent">
      <?php foreach ($total_vocab as $index => $group): ?>
        <?php if (in_array($group['category'], ['Consonant(S1)', 'Consonant(S2)'])): ?>
          <div class="tab-pane fade <?php echo $index === 0 ? 'show active' : ''; ?>"
               id="tab-content-<?php echo $index; ?>"
               role="tabpanel"
               aria-labelledby="sidebar-tab-<?php echo $index; ?>">
            <div class="sv-tab-panel">
              <div class="table-responsive">
                <table class="waffle">
                  <thead>
                    <tr>
                      <td> </td>
                      <td></td>
                      <td>script</td>
                      <td>script</td>
                      <td>script</td>
                      <td>script</td>
                    </tr>
                    <tr>
                      <td>sound #</td>
                      <td>combination</td>
                      <td>Khmer</td>
                      <td>Devanagari</td>
                      <td>Roman</td>
                      <td>IPA</td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($group['data'] as $vocab): ?>
                      <tr>
                        <td><?php echo $vocab['serial_number']; ?></td>
                        <td><?php echo $vocab['combination']; ?></td>
                        <td><?php echo $vocab['khmer']; ?></td>
                        <td><?php echo $vocab['devanagari']; ?></td>
                        <td><?php echo $vocab['roman']; ?></td>
                        <td><?php echo $vocab['ipa']; ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        <?php else: ?>
          <?php foreach ($group['serials'] as $si => $serial): ?>
            <div class="tab-pane fade"
                 id="tab-content-<?php echo $index . '-' . $si; ?>"
                 role="tabpanel"
                 aria-labelledby="sidebar-serial-<?php echo $index . '-' . $si; ?>">
              <div class="sv-tab-panel">
                <div class="table-responsive">
                  <table class="waffle">
                    <thead>
                      <tr>
                        <td> </td>
                        <td></td>
                        <td>script</td>
                        <td>script</td>
                        <td>script</td>
                        <td>script</td>
                      </tr>
                      <tr>
                        <td>sound #</td>
                        <td>combination</td>
                        <td>[translate:Khmer]</td>
                        <td>Devanagari</td>
                        <td>Roman</td>
                        <td>IPA</td>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($serial['data'] as $vocab): ?>
                        <tr>
                          <td><?php echo $vocab['serial_number']; ?></td>
                          <td><?php echo $vocab['combination']; ?></td>
                          <td><?php echo $vocab['khmer']; ?></td>
                          <td><?php echo $vocab['devanagari']; ?></td>
                          <td><?php echo $vocab['roman']; ?></td>
                          <td><?php echo $vocab['ipa']; ?></td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </div>
</div>
</section>
