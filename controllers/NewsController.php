<?php
class NewsController {
     
    public function obtainNews() {
        $news = new NewsModel();
        return json_encode($news->find('*', 'ID DESC', 10));
    }

}