<?php
namespace MathPHP\Probability\Distribution\Continuous;

use MathPHP\Functions\Support;

class Laplace extends Continuous
{
    /**
     * Distribution parameter bounds limits
     * μ ∈ (-∞,∞)
     * b ∈ (0,∞)
     * @var array
     */
    const PARAMETER_LIMITS = [
        'μ' => '(-∞,∞)',
        'b' => '(0,∞)',
    ];

    /**
     * Distribution support bounds limits
     * x ∈ (-∞,∞)
     * @var array
     */
    const SUPPORT_LIMITS = [
        'x' => '(-∞,∞)',
    ];

     /** @var float location parameter */
    protected $μ;

     /** @var float scale parameter */
    protected $b;

    /**
     * Constructor
     *
     * @param number $μ location parameter
     * @param number $b scale parameter (diversity)  b > 0
     */
    public function __construct($μ, $b)
    {
        parent::__construct($μ, $b);
    }

    /**
     * Laplace distribution - probability density function
     *
     * https://en.wikipedia.org/wiki/Laplace_distribution
     *
     *            1      /  |x - μ| \
     * f(x|μ,b) = -- exp| - -------  |
     *            2b     \     b    /
     *
     * @param  number $x
     *
     * @return float
     */
    public function pdf($x): float
    {
        Support::checkLimits(self::SUPPORT_LIMITS, ['x' => $x]);

        $μ = $this->μ;
        $b = $this->b;

        return (1 / (2 * $b)) * exp(-( abs($x - $μ)/$b ));
    }
    /**
     * Laplace distribution - cumulative distribution function
     * From -∞ to x (lower CDF)
     * https://en.wikipedia.org/wiki/Laplace_distribution
     *
     *        1     / x - μ \
     * F(x) = - exp|  ------ |       if x < μ
     *        2     \   b   /
     *
     *            1     /  x - μ \
     * F(x) = 1 - - exp| - ------ |  if x ≥ μ
     *            2     \    b   /
     *
     * @param  number $x
     *
     * @return float
     */
    public function cdf($x): float
    {
        Support::checkLimits(self::SUPPORT_LIMITS, ['x' => $x]);

        $μ = $this->μ;
        $b = $this->b;

        if ($x < $μ) {
            return (1/2) * exp(($x - $μ) / $b);
        }
        return 1 - (1/2) * exp(-($x - $μ) / $b);
    }
    
    /**
     * Mean of the distribution
     *
     * μ = μ
     *
     * @return μ
     */
    public function mean()
    {
        return $this->μ;
    }
}
