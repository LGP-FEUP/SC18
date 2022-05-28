import 'package:erasmus_helper/models/culture_entry.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

class CultureContent extends StatelessWidget {
  const CultureContent({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    final entry = Provider.of<CultureEntry>(context);

    return Column(children: <Widget>[
      const SizedBox(height: 10),
      Align(
        alignment: Alignment.centerLeft,
        child: Padding(
          padding: const EdgeInsets.symmetric(horizontal: 10),
          child: Text(
            entry.title,
            style: const TextStyle(fontSize: 18),
          ),
        ),
      ),
      const SizedBox(
        height: 10,
      ),
      Padding(
        padding: const EdgeInsets.symmetric(horizontal: 5),
        child: Row(
          children: <Widget>[
            const Icon(
              Icons.location_on,
              color: Colors.blue,
            ),
            const SizedBox(
              width: 2,
            ),
            Text(
              entry.location,
            ),
          ],
        ),
      ),
      const SizedBox(
        height: 10,
      ),
      Padding(
          padding: const EdgeInsets.symmetric(horizontal: 10),
          child: Text(entry.description))
    ]);
  }
}
