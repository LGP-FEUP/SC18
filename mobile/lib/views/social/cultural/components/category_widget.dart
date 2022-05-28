import 'package:erasmus_helper/models/culture_category.dart';
import 'package:erasmus_helper/views/social/cultural/culture_state.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

class CategoryWidget extends StatelessWidget {
  final CultureCategory category;

  const CategoryWidget({Key? key, required this.category}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    final cultureState = Provider.of<CultureState>(context);
    final isSelected = cultureState.selectedCategoryId == category.categoryId;

    return GestureDetector(
      onTap: () {
        if (!isSelected) {
          cultureState.updateCategoryId(category.categoryId);
        }
      },
      child: Container(
        margin: const EdgeInsets.only(left: 5, top: 10, bottom: 10),
        width: 90,
        height: 90,
        decoration: BoxDecoration(
          border: Border.all(color: Theme.of(context).primaryColor, width: 2),
          borderRadius: const BorderRadius.all(Radius.circular(16)),
          color: isSelected ? Theme.of(context).primaryColor : Colors.white,
        ),
        child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: <Widget>[
              Icon(
                category.icon,
                color:
                    isSelected ? Colors.white : Theme.of(context).primaryColor,
                size: 40,
              ),
              const SizedBox(
                height: 10,
              ),
              Text(category.name,
                  style: TextStyle(
                      color: isSelected
                          ? Colors.white
                          : Colors.black)),
            ]),
      ),
    );
  }
}
