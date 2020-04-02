<?php


namespace Modules\Icommerce\Support;

use Modules\Icommerce\Entities\OptionValue;
use Modules\Icommerce\Repositories\OptionValueRepository;

class OptionValuesOrdener
{


  /**
   * @var OptionValueRepository
   */
  private $optionValueRepository;

  /**
   * @param OptionValueRepository $optionValueRepository
   */
  public function __construct(OptionValueRepository $optionValueRepository)
  {
    $this->optionValueRepository = $optionValueRepository;
  }

  /**
   * @param $data
   */
  public function handle($data)
  {
    $data = $this->convertToArray(json_decode($data));

    foreach ($data as $position => $item) {
      $this->order($position, $item);
    }
  }

  /**
   * Order recursively the menu items
   * @param int   $position
   * @param array $item
   */
  private function order($position, $item)
  {
    $optionValue = $this->optionValueRepository->find($item['id']);
    if (0 === $position && false === $optionValue->isRoot()) {
      return;
    }
    $this->savePosition($optionValue, $position);
    $this->makeItemChildOf($optionValue, null);

    if ($this->hasChildren($item)) {
      $this->handleChildrenForParent($optionValue, $item['children']);
    }
  }

  /**
   * @param Menuitem $parent
   * @param array    $children
   */
  private function handleChildrenForParent(OptionValue $parent, array $children)
  {
    foreach ($children as $position => $item) {
      $optionValue = $this->optionValueRepository->find($item['id']);
      $this->savePosition($optionValue, $position);
      $this->makeItemChildOf($optionValue, $parent->id);

      if ($this->hasChildren($item)) {
        $this->handleChildrenForParent($optionValue, $item['children']);
      }
    }
  }

  /**
   * Save the given position on the menu item
   * @param object $optionValue
   * @param int    $position
   */
  private function savePosition($optionValue, $position)
  {
    $this->optionValueRepository->update($optionValue, compact('position'));
  }

  /**
   * Check if the item has children
   *
   * @param  array $item
   * @return bool
   */
  private function hasChildren($item)
  {
    return isset($item['children']);
  }

  /**
   * Set the given parent id on the given menu item
   *
   * @param object $item
   * @param int    $parent_id
   */
  private function makeItemChildOf($item, $parent_id)
  {
    $this->optionValueRepository->update($item, compact('parent_id'));
  }

  /**
   * Convert the object to array
   * @param $data
   * @return array
   */
  private function convertToArray($data)
  {
    $data = json_decode(json_encode($data), true);

    return $data;
  }

}