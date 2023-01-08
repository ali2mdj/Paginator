<?php
class Paginator
{
    protected $perPage;
    protected $currentPage;
    protected $path = '/';
    public $onEachSide = 3;
    protected $totalRows;
    protected $totalPages;

    public function __construct($totalRows, $path, $perPage = 15) {
        $this->perPage  = $perPage;
        $this->totalRows = $totalRows;
        $this->path = $path;
        if(strpos($path,"?") !== false) {
            $this->path = $this->path."&page=";
        } else {
            $this->path = $this->path."?page=";
        }
        $this->totalPages = ceil($this->totalRows / $this->perPage);
        $currentPage = 1;
        if(isset($_REQUEST["page"]) && trim($_REQUEST["page"]) != "") {
            $currentPage = $_REQUEST["page"];
        }
        if($this->isValidPageNumber($currentPage)) {
            $this->currentPage = $currentPage;
        } else {
            $this->currentPage = 1;
        }
        if($this->currentPage > $this->totalPages) {
            $this->currentPage = $this->totalPages;
        }
    }

    public function getOffset() {
        $start = $this->currentPage - 1;
        return $start * $this->perPage;
    }

    protected function isValidPageNumber($page)
    {
        return $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false;
    }

    public function hasPages() {
        return $this->totalPages > 1;
    }

    public function onFirstPage() {
        return $this->currentPage == 1;
    }

    public function hasMorePages() {
        return $this->currentPage < $this->totalPages;
    }

    public function previousPageUrl() {
        $previous = $this->currentPage - 1;
        return $this->path.$previous;
    }

    public function nextPageUrl() {
        $next = $this->currentPage + 1;
        return $this->path.$next;
    }

    public function currentPage() {
        return $this->currentPage;
    }

    public function getPagingElements() {
        $elements = array();
        $start_added = false;
        $end_added = false;
        $total = ($this->onEachSide * 2) + 7;
        $low = ceil($total / 2.0);
        $high = floor($total / 2.0);
        for($pCounter = 1; $pCounter <= $this->totalPages; $pCounter++) {
            if($pCounter < 3) {
                $elements[] = array("page" => $pCounter, "link" => $this->path.$pCounter);
            }
            elseif ($pCounter > $this->totalPages - 2) {
                $elements[] = array("page" => $pCounter, "link" => $this->path.$pCounter);
            }
            else {
                if($pCounter < $this->currentPage) {
                    if($this->currentPage == $low) {
                        $elements[] = array("page" => $pCounter, "link" => $this->path . $pCounter);
                    } elseif($pCounter < $this->currentPage - $this->onEachSide) {
                        if ($pCounter >= $this->totalPages - (($this->onEachSide * 2) + ($end_added?2:3))) {
                            $elements[] = array("page" => $pCounter, "link" => $this->path . $pCounter);
                        } elseif(!$start_added) {
                            $elements[] = "...";
                            $start_added = true;
                        } else {
                            continue;
                        }
                    } else {
                        $elements[] = array("page" => $pCounter, "link" => $this->path . $pCounter);
                    }
                }
                if($pCounter > $this->currentPage) {
                    if($this->currentPage == $this->totalPages - $high) {
                        $elements[] = array("page" => $pCounter, "link" => $this->path . $pCounter);
                    } elseif($pCounter > $this->currentPage + $this->onEachSide) {
                        if ($pCounter <= ($this->onEachSide * 2) + ($start_added?3:4)) {
                            $elements[] = array("page" => $pCounter, "link" => $this->path . $pCounter);
                        } elseif(!$end_added) {
                            $elements[] = "...";
                            $end_added = true;
                        } else {
                            continue;
                        }
                    } else {
                        $elements[] = array("page" => $pCounter, "link" => $this->path . $pCounter);
                    }
                }
                if($pCounter == $this->currentPage) {
                    $elements[] = array("page" => $pCounter, "link" => $this->path . $pCounter);
                }
            }
        }
        return $elements;
    }

}
