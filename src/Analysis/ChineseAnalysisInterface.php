<?php
namespace  Woodfish\Stemmer\Analysis;

interface ChineseAnalysisInterface
{
    public function setSource($source);

    public function startAnalysis($optimize = true);

    public function getFinallyResult($spword = ' ', $word_meanings = false);
}
