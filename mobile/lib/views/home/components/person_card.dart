import 'package:erasmus_helper/models/user.dart';
import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';

class PersonCard extends StatelessWidget {
  final UserModel user;

  const PersonCard(this.user, {Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Card(
      elevation: 3,
      child: SizedBox(
        height: 250,
        width: 160,
        child: Stack(
          alignment: Alignment.topCenter,
          children: [
            Column(
              children: [
                SizedBox(
                  height: 90,
                  child: SvgPicture.asset(
                    "assets/flags/${user.countryCode ?? "eu"}.svg",
                    fit: BoxFit.fill,
                  ),
                ),
                const SizedBox(
                  height: 15,
                ),
                Container(
                  padding: const EdgeInsets.all(8.0),
                  child: Column(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      Text(
                        "${user.fName} ${user.lName}",
                        style: const TextStyle(
                          fontWeight: FontWeight.bold,
                          overflow: TextOverflow.ellipsis,
                        ),
                        textAlign: TextAlign.center,
                        maxLines: 3,
                        overflow: TextOverflow.ellipsis,
                      ),
                      const SizedBox(
                        height: 5.0,
                      ),
                      Text(
                        user.description ?? "No description",
                        textAlign: TextAlign.center,
                        maxLines: 3,
                        overflow: TextOverflow.ellipsis,
                      ),
                    ],
                  ),
                ),
              ],
            ),
            Positioned(
                left: 35,
                top: 20,
                child: CircleAvatar(
                    backgroundColor: Colors.white,
                    radius: 45,
                    child: CircleAvatar(
                      radius: 40,
                      backgroundImage: NetworkImage(user.avatar!),
                    )))
          ],
        ),
      ),
    );
  }
}
