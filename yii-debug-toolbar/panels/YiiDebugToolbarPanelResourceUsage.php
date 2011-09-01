<?php
/**
 * YiiDebugToolbarPanelResourceUsage class file.
 *
 * @author Sergey Malyshev <malyshev.php@gmail.com>
 */


/**
 * YiiDebugToolbarPanelResourceUsage represents an ...
 *
 * Description of YiiDebugToolbarPanelResourceUsage
 *
 * @author Sergey Malyshev <malyshev.php@gmail.com>
 * @author Igor Golovanov <igor.golovanov@gmail.com>
 * @version $Id$
 * @package YiiDebugToolbar
 * @since 1.1.7
 */
class YiiDebugToolbarPanelResourceUsage extends YiiDebugToolbarPanel
{
    private $_loadTime;

    public function getLoadTime()
    {
        if (null === $this->_loadTime)
        {
            $this->_loadTime = $this->owner->owner->getLoadTime();
        }
        return $this->_loadTime;
    }

    public function getRequestLoadTime()
    {
        return ($this->owner->owner->getEndTime() - $_SERVER['REQUEST_TIME']);
    }

    /**
     * {@inheritdoc}
     */
    public function getMenuTitle()
    {
        return Yii::t('yii-debug-toolbar', 'Resources');
    }

    /**
     * {@inheritdoc}
     */
    public function getMenuSubTitle()
    {
		return Yii::t('yii-debug-toolbar', 'Total time: {n} s.', array(vsprintf('%0.6F',$this->getLoadTime())));
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return Yii::t('yii-debug-toolbar', 'Resource Usage');
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {

        $resources =  array(
            Yii::t('yii-debug-toolbar', 'Page Load Time')    =>  sprintf('%0.3F s.',$this->getLoadTime()),
            Yii::t('yii-debug-toolbar', 'Elapsed Time')      =>  sprintf('%0.3F s.',$this->getRequestLoadTime()),
            Yii::t('yii-debug-toolbar', 'Memory Usage')      =>  number_format(Yii::getLogger()->getMemoryUsage()/1024) . ' KB',
            Yii::t('yii-debug-toolbar', 'Memory Peak Usage') =>  number_format(memory_get_peak_usage()/1024) . ' KB',
        );

        if (function_exists('mb_strlen') && isset($_SESSION))
        {
            $resources[Yii::t('yii-debug-toolbar', 'Session Size')] = sprintf('%0.3F KB' ,mb_strlen(serialize($_SESSION))/1024);
        }

        $this->render('resource_usage', array(
            'resources' => $resources
        ));
    }
}
