<div class="attachments index">

        <div class="actions">
                <ul>
                        <li>
                                <?php echo $html->link(__('Edit attachments', true), array(
                                    'plugin' => 'nodeattachment',
                                    'controller' => 'nodeattachment',
                                    'action'=>'index',
                                    $this->data['Node']['id'])); ?>
                        </li>
                </ul>
        </div>

        <table cellpadding="0" cellspacing="0">
                <?php
                $tableHeaders = $html->tableHeaders(array(
                            'id',
                            '&nbsp;',
                            __('Title', true),
                            __('URL', true),
                        ));
                echo $tableHeaders;

                $rows = array();
                foreach ($this->data['Attachments'] AS $attachment) {

                        $mimeType = explode('/', $attachment['Node']['mime_type']);
                        $mimeType = $mimeType['0'];
                        if ($mimeType == 'image') {
                                $thumbnail = $html->link($image->resize('/uploads/' . $attachment['Node']['slug'], 100, 200), '#', array('escape' => false));
                        } else {
                                $thumbnail = $html->image('/img/icons/page_white.png') . ' ' . $attachment['Node']['mime_type'] . ' (' . $filemanager->filename2ext($attachment['Node']['slug']) . ')';
                        }

                        $rows[] = array(
                            $attachment['Node']['id'],
                            $thumbnail,
                            $attachment['Node']['title'],
                            $html->link($text->truncate($html->url($attachment['Node']['path'], true), 20), $attachment['Node']['path']),
                        );
                }

                echo $html->tableCells($rows);
                echo $tableHeaders;
                ?>
        </table>
</div>